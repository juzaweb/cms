<?php

namespace Juzaweb\DevTool\Commands\Theme;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Facades\Theme;

class GenerateDataThemeCommand extends Command
{
    protected $signature = 'theme:generate-data {theme}';

    public function handle()
    {
        $theme = $this->argument('theme');
        if (!Theme::has($theme)) {
            $this->error('Theme not exists.');
            exit();
        }

        $register = Theme::getRegister($theme);
        $this->dataWidgets($theme, $register);
        $this->dataBlocks($theme, $register);
        $this->dataTemplates($theme, $register);

        File::put(
            Theme::getThemePath($theme, 'register.json'),
            json_encode($register, JSON_PRETTY_PRINT)
        );

        $this->info('Generate Data successful');

        return self::SUCCESS;
    }

    protected function dataWidgets($theme, &$register)
    {
        $widgets = File::files(
            Theme::getThemePath(
                $theme,
                'views/components/widgets'
            )
        );

        foreach ($widgets as $widget) {
            $key = $this->getNameFile($widget->getFilename());
            $this->makeFormJson(
                $theme,
                $widget->getRealPath(),
                "data/widgets/{$key}.json"
            );

            if (Arr::has($register['widgets'] ?? [], $key)) {
                continue;
            }

            $label = $this->makeLabelFormKey($key);

            $register['widgets'][$key] = [
                "label" => $label,
                "description" => $label,
                "view" => "theme::components.widgets.{$key}",
            ];
        }
    }

    protected function dataBlocks($theme, &$register)
    {
        $widgets = File::files(
            Theme::getThemePath(
                $theme,
                'views/components/blocks'
            )
        );

        foreach ($widgets as $widget) {
            $key = $this->getNameFile($widget->getFilename());
            $this->makeFormJson(
                $theme,
                $widget->getRealPath(),
                "data/blocks/{$key}.json"
            );

            if (Arr::has($register['blocks'] ?? [], $key)) {
                continue;
            }

            $label = $this->makeLabelFormKey($key);

            $register['blocks'][$key] = [
                "label" => $label,
                "description" => $label,
                "view" => "theme::components.widgets.{$key}",
            ];
        }
    }

    protected function dataTemplates($theme, &$register)
    {
        $files = File::files(
            Theme::getThemePath(
                $theme,
                'views/templates'
            )
        );

        foreach ($files as $file) {
            $key = $this->getNameFile($file->getFilename());
            if (Arr::has($register['templates'] ?? [], $key)) {
                continue;
            }

            $label = str_replace(['_', '-'], ' ', $key);
            $label = ucwords($label);

            $register['templates'][$key] = [
                "label" => $label,
                "view" => "theme::templates.{$key}",
            ];
        }
    }

    protected function makeFormJson($theme, $path, $output)
    {
        $text = File::get($path);
        preg_match_all('/data\.([a-z]+)/', $text, $matches);

        $fields = $matches[1] ?? [];
        $dataPath = Theme::getThemePath(
            $theme,
            $output
        );

        if (file_exists($dataPath)) {
            $data = json_decode(File::get($dataPath), true);
            $form = $data['form'];
        } else {
            $data = [];
            $form = [];
        }

        $formFields = collect($form)
            ->keyBy('name')
            ->keys()
            ->toArray();

        $fields = array_unique($fields);
        foreach ($fields as $field) {
            if (in_array($field, $formFields)) {
                continue;
            }

            $form[] = $this->makeFieldByName($field);
        }

        $data['form'] = $form;
        File::put(
            $dataPath,
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }

    protected function makeFieldByName($name)
    {
        $label = $this->makeLabelFormKey($name);
        switch ($name) {
            case 'image':
                return [
                    "type" => "image",
                    "name" => $name,
                    "label" => $label
                ];
            case 'taxonomy':
                return [
                    "type" => "taxonomy",
                    "name" => $name,
                    "label" => $label,
                    "data" => [
                        "post_type" => "__POST_TYPE__",
                    ]
                ];
            case 'taxonomies':
            case 'categories':
                return [
                    "type" => "taxonomy",
                    "name" => $name,
                    "label" => $label,
                    "data" => [
                        "post_type" => "__POST_TYPE__",
                        "multiple" => true
                    ]
                ];
            case 'category':
                return [
                    "type" => "taxonomy",
                    "name" => $name,
                    "label" => $label,
                    "data" => [
                        "post_type" => "__POST_TYPE__"
                    ]
                ];
            case 'resource':
                return [
                    "type" =>"resource",
                    "name" => $name,
                    "label" => $label,
                    "data" => [
                        "type" => "__TYPE__"
                    ]
                ];
            case 'limit':
                return [
                    "type" => "number",
                    "name" => $name,
                    "label" => $label,
                    "data" => [
                        "default" => 10
                    ]
                ];
            default:
                return [
                    "type" => "text",
                    "name" => $name,
                    "label" => $label
                ];
        }
    }

    protected function makeLabelFormKey($key): string
    {
        $label = str_replace(['_', '-'], ' ', $key);
        $label = ucwords($label);
        return $label;
    }

    protected function getNameFile($fileName): array|string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        return str_replace('.' . $extension, '', $fileName);
    }
}
