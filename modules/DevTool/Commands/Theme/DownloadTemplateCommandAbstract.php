<?php

namespace Juzaweb\DevTool\Commands\Theme;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

abstract class DownloadTemplateCommandAbstract extends Command
{
    protected Client $client;

    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    protected function setDataDefault(string $key, string $value): void
    {
        $data = Cache::get('html_download', []);

        $data[$key] = $value;

        Cache::forever('html_download', $data);
    }

    protected function getDataDefault(string $key, string $default = null): ?string
    {
        $data = Cache::get('html_download', []);

        return Arr::get($data, $key, $default);
    }

    protected function getFontExtensions(): array
    {
        return [
            'eot',
            'woff2',
            'woff',
            'ttf',
            'svg'
        ];
    }

    protected function downloadFile(string $url, string $path)
    {
        $folder = dirname($path);

        if (!is_dir($folder)) {
            File::makeDirectory($folder, 0755, true);
        }

        $this->client->request(
            'GET',
            $url,
            [
                'sink' => $path,
                'verify' => false
            ]
        );
    }

    protected function getFileContent(string $url): string
    {
        return $this->client->request(
            'GET',
            $url,
            [
                'verify' => false
            ]
        )->getBody()->getContents();
    }

    protected function curlGet(string $url): string
    {
        $curl = $this->client->get(
            $url,
            [
                'timeout' => 10,
                'verify' => false
            ]
        );

        return $curl->getBody()->getContents();
    }

    protected function isExcludeDomain(string $url): bool
    {
        return in_array(
            $this->getDomainUrl($url),
            [
                'fonts.googleapis.com',
                'maps.googleapis.com',
            ]
        );
    }

    protected function getDomainUrl(string $url): string
    {
        return get_domain_by_url($url);
    }
}
