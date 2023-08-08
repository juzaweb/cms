<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Html;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Contracts\Field as FieldContract;
use Juzaweb\CMS\Support\Html\Traits\InputField;

class Field implements FieldContract
{
    use InputField;

    public function render(array $fields, array|Model $values = [], bool $collection = false): View|Factory
    {
        if (!$collection) {
            $fields = $this->collect($fields)->toArray();
        }

        return view('cms::components.render_fields', compact('fields', 'values'));
    }

    public function row(array $options, array|Model $values = []): View|Factory
    {
        $options = new Collection($options);

        return view('cms::components.form_row', compact('options', 'values'));
    }

    public function col(array $options, array|Model $values = []): View|Factory
    {
        $options = new Collection($options);

        return view('cms::components.form_col', compact('options', 'values'));
    }

    public function collect(array $fields): Collection
    {
        return (new Collection($fields))
            ->mapWithKeys(
                function ($item, $key) {
                    $default = [
                        'type' => 'text',
                        'sidebar' => false,
                        'visible' => true,
                    ];

                    if (is_array($item)) {
                        $default['label'] = trans("cms::app.{$key}");

                        return [$key => array_merge($default, $item)];
                    } else {
                        $default['label'] = trans("cms::app.{$item}");

                        return [$item => $default];
                    }
                }
            );
    }

    public function fieldByType(array $data): View|Factory|string
    {
        $type = Arr::get($data, 'type');

        return match ($type) {
            'text' => $this->text(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'editor' => $this->editor(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'textarea' => $this->textarea(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'select' => $this->select(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'post' => $this->selectPost(
                $data['label'],
                ($input['data']['multiple'] ?? false) ?
                    "{$data['name']}[]"
                    : $data['name'],
                Arr::get($data, 'data', [])
            ),
            'taxonomy' => $this->selectTaxonomy(
                $data['label'],
                ($input['data']['multiple'] ?? false) ?
                    "{$data['name']}[]"
                    : $data['name'],
                Arr::get($data, 'data', [])
            ),
            'resource' => $this->selectResource(
                $data['label'],
                ($input['data']['multiple'] ?? false) ?
                    "{$data['name']}[]"
                    : $data['name'],
                Arr::get($data, 'data', [])
            ),
            'image' => $this->image(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'images' => $this->images(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'checkbox' => $this->checkbox(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'upload_url' => $this->uploadUrl(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'security' => $this->security(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            'filter_posts' => $this->filterPosts(
                $data['label'],
                $data['name'],
                Arr::get($data, 'data', [])
            ),
            default => '',
        };
    }

    public function mapOptions(string|Model $label, ?string $name, ?array $options = []): ?array
    {
        $options['name'] = $name;
        $options['id'] = Arr::get(
            $options,
            'id',
            'a'. Str::random(5) . '-' . $name
        );

        $options['id'] = Str::slug($options['id']);

        if ($label instanceof Model) {
            $options['value'] = Arr::get(
                $options,
                'value',
                $label->getAttribute($name) ?? $options['default'] ?? null
            );

            if (is_callable($options['value'])) {
                $options['value'] = call_user_func($options['value'], ...[$label, $name, $options]);
            }

            $options['label'] = $options['label'] ?? $label->attributeLabel($name);
        } else {
            $options['value'] = $options['value'] ?? $options['default'] ?? null;

            if (!is_string($options['value']) && is_callable($options['value'])) {
                $options['value'] = call_user_func($options['value'], ...[$label, $name, $options]);
            }
        }

        if (is_string($label)) {
            $options['label'] = $label;
        }

        return $options;
    }
}
