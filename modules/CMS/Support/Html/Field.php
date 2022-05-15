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

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Models\User;

class Field
{
    public static function text($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_input', $options);
    }

    public static function textarea($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_textarea', $options);
    }

    public static function select($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_select', $options);
    }

    public static function checkbox($label, $name, $options = [])
    {
        $options['value'] = Arr::get($options, 'value', 1);
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_checkbox', $options);
    }

    public static function slug($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_slug', $options);
    }

    public static function editor($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_ckeditor', $options);
    }

    public static function selectTaxonomy($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_select_taxonomy', $options);
    }

    public static function selectResource($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_select_resource', $options);
    }

    public static function selectUser($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);
        $value = $options['value'] ?? [];
        $value = !is_array($value) ? [$value] : $value;

        $opts = [];
        if ($value) {
            $opts = User::whereIn('id', $value)
                ->get(['id', 'name'])
                ->mapWithKeys(function ($item) {
                    return [
                        $item->id => $item->name
                    ];
                })
                ->toArray();
        }

        $options['options'] = $opts;
        $options['value'] = $value;
        return view('cms::components.form_select_user', $options);
    }

    public static function image($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_image', $options);
    }

    public static function images($label, $name, $options = [])
    {
        $options = static::mapOptions($label, $name, $options);

        return view('cms::components.form_images', $options);
    }

    public static function fieldByType($data)
    {
        $type = Arr::get($data, 'type');
        switch ($type) {
            case 'text':
                return static::text(
                    $data['label'],
                    $data['name'],
                    Arr::get($data, 'data', [])
                );
            case 'editor':
                return static::editor(
                    $data['label'],
                    $data['name'],
                    Arr::get($data, 'data', [])
                );
            case 'textarea':
                return static::textarea(
                    $data['label'],
                    $data['name'],
                    Arr::get($data, 'data', [])
                );
            case 'select':
                return static::select(
                    $data['label'],
                    $data['name'],
                    Arr::get($data, 'data', [])
                );
            case 'taxonomy':
                return static::selectTaxonomy(
                    $data['label'],
                    ($input['data']['multiple'] ?? false) ?
                            "{$data['name']}[]"
                                : $data['name'],
                    Arr::get($data, 'data', [])
                );
            case 'resource':
                return static::selectResource(
                    $data['label'],
                    ($input['data']['multiple'] ?? false) ?
                        "{$data['name']}[]"
                        : $data['name'],
                    Arr::get($data, 'data', [])
                );
            case 'image':
                return static::image(
                    $data['label'],
                    $data['name'],
                    Arr::get($data, 'data', [])
                );
            case 'images':
                return static::images(
                    $data['label'],
                    $data['name'],
                    Arr::get($data, 'data', [])
                );
        }

        return '';
    }

    public static function mapOptions($label, $name, $options = [])
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
        }

        if (is_string($label)) {
            $options['label'] = $label;
        }

        return $options;
    }
}
