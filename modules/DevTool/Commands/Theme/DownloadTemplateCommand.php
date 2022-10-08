<?php

namespace Juzaweb\DevTool\Commands\Theme;

use Illuminate\Support\Facades\File;

class DownloadTemplateCommand extends DownloadTemplateCommandAbstract
{
    protected $signature = 'html:download';

    protected array $data;

    public function handle()
    {
        $this->sendBaseDataAsks();

        $this->downloadFileAsks();
    }

    protected function sendBaseDataAsks(): void
    {
        $this->data['name'] = $this->ask(
            'Theme Name?',
            $this->getDataDefault('name')
        );

        $this->setDataDefault('name', $this->data['name']);

        $this->data['container'] = $this->ask(
            'Theme Container?',
            $this->getDataDefault('container', '.container-fluid')
        );

        $this->setDataDefault('container', $this->data['container']);
    }

    protected function downloadFileAsks(): void
    {
        $this->data['url'] = $this->ask(
            'Url Template?',
            $this->getDataDefault('url')
        );

        $this->setDataDefault('url', $this->data['url']);

        $this->data['file'] = $this->ask(
            'Theme File?',
            $this->getDataDefault('file', 'index.twig')
        );

        $this->setDataDefault('file', $this->data['file']);

        $extension = pathinfo($this->data['file'], PATHINFO_EXTENSION);

        if ($extension != 'twig') {
            $this->data['file'] = "{$this->data['file']}.twig";
        }

        $path = "themes/{$this->data['name']}/views/{$this->data['file']}";

        $contents = $this->getFileContent($this->data['url']);

        $content = str_get_html($contents)->find($this->data['container'], 0)->outertext;

        File::put(
            $path,
            "{% extends 'cms::layouts.frontend' %}

                {% block content %}
                    {$content}
                {% endblock %}"
        );
    }
}
