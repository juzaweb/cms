<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Html;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Contracts\Field as FieldContract;

class Field implements FieldContract
{
    public function text(string|Model $label, ?string $name, ?array $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_input', $options);
    }

    public function hidden($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_input', $options);
    }

    public function textarea($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_textarea', $options);
    }

    public function select($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_select', $options);
    }

    public function checkbox($label, $name, $options = []): Factory|View
    {
        $options['value'] = Arr::get($options, 'value', 1);
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_checkbox', $options);
    }

    public function slug($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_slug', $options);
    }

    public function editor($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_ckeditor', $options);
    }

    public function selectPost($label, $name, $options = []): View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_select_post', $options);
    }

    public function selectTaxonomy($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_select_taxonomy', $options);
    }

    public function selectResource($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_select_resource', $options);
    }

    public function selectUser($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);
        $value = $options['value'] ?? [];
        $value = !is_array($value) ? [$value] : $value;

        $opts = [];
        if ($value) {
            $opts = User::whereIn('id', $value)
                ->get(['id', 'name'])
                ->mapWithKeys(
                    function ($item) {
                        return [
                            $item->id => $item->name
                        ];
                    }
                )
                ->toArray();
        }

        $options['options'] = $opts;
        $options['value'] = $value;
        return view('cms::components.form_select_user', $options);
    }

    public function image($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_image', $options);
    }

    public function images($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_images', $options);
    }

    public function uploadUrl($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_upload_url', $options);
    }

    public function security($label, $name, $options = []): Factory|View
    {
        $options = $this->mapOptions($label, $name, $options);

        return view('cms::components.form_security', $options);
    }

    public function fieldByType($data): View|Factory|string
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
            default => '',
        };
    }

    public function mapOptions($label, $name, $options = [])
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
                $label->getAttribute($name)
            );
            $options['label'] = $options['label'] ?? $label->attributeLabel($name);
        } else {
            $options['value'] = $options['value'] ?? $options['default'] ?? null;
        }

        if (is_string($label)) {
            $options['label'] = $label;
        }

        return $options;
    }
}
