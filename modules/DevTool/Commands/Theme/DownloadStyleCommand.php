<?php

namespace Juzaweb\DevTool\Commands\Theme;

use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Support\HtmlDom;

class DownloadStyleCommand extends DownloadTemplateCommandAbstract
{
    protected $signature = 'style:download';

    protected array $data;

    public function handle()
    {
        $this->sendAsks();

        $html = $this->curlGet($this->data['url']);

        $domp = str_get_html($html);

        $css = $this->downloadCss($domp);

        $js = $this->downloadJs($domp);

        $mix = "const mix = require('laravel-mix');

mix.styles([
    ". implode(",\n", $css) ."
], 'themes/{$this->data['name']}/assets/public/css/main.css');

mix.combine([
    ". implode(",\n", $js) ."
], 'themes/{$this->data['name']}/assets/public/js/main.js');";

        File::put("themes/{$this->data['name']}/assets/mix.js", $mix);
    }

    protected function sendAsks()
    {
        $this->data['url'] = $this->ask(
            'Url Template?',
            $this->getDataDefault('url')
        );

        $this->setDataDefault('url', $this->data['url']);

        $this->data['name'] = $this->ask(
            'Theme Name?',
            $this->getDataDefault('name')
        );

        $this->setDataDefault('name', $this->data['name']);
    }

    protected function downloadCss(HtmlDom $domp): array
    {
        $result = [];
        foreach ($domp->find('link[rel="stylesheet"]') as $e) {
            $href = $e->href;
            $href = $this->parseHref($href);

            if ($this->isExcludeDomain($href)) {
                continue;
            }

            $name = explode('?', basename($href))[0];

            $path = "themes/{$this->data['name']}/assets/styles/css/{$name}";

            $this->downloadFile($href, base_path($path));

            $result[] = "'{$path}'";

            $this->info("-- Downloaded file {$path}");
        }
        return $result;
    }

    protected function downloadJs(HtmlDom $domp): array
    {
        $result = [];
        foreach ($domp->find('script') as $e) {
            $href = $e->src;
            if (empty($href)) {
                continue;
            }

            $href = $this->parseHref($href);

            $this->info("-- Download file {$href}");

            if ($this->isExcludeDomain($href)) {
                continue;
            }

            $name = explode('?', basename($href))[0];

            $path = "themes/{$this->data['name']}/assets/styles/js/{$name}";

            try {
                $this->downloadFile($href, base_path($path));
                $result[] = "'{$path}'";
                $this->info("-- Downloaded file {$path}");
            } catch (\Exception $e) {
                $this->warn("Download error: {$href}");
            }
        }

        return $result;
    }

    protected function parseHref($href): mixed
    {
        if (str_starts_with($href, '//')) {
            $href = 'https:' . $href;
        }

        if (!is_url($href)) {
            $baseUrl = explode('/', $this->data['url'])[0];
            $baseUrl .= '://' . get_domain_by_url($this->data['url']);

            if (str_starts_with($href, '/')) {
                $href = $baseUrl . trim($href);
            } else {
                $dir = dirname($this->data['url']);
                $href = "{$dir}/" . trim($href);
            }
        }

        return $href;
    }
}
