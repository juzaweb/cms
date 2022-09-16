<?php

namespace Juzaweb\Backend\Commands;

use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Juzaweb\Backend\Models\Post;

class AutoSubmitCommand extends Command
{
    protected $signature = 'juzacms:auto-submit';

    protected $description = 'Auto ping sitemap and submit url for SEO.';

    public function handle(): int
    {
        if (!get_config('jw_auto_ping')) {
            return self::SUCCESS;
        }

        if ($this->checkSubmitDate()) {
            set_config('jw_last_seo_ping', date('Y-m-d H:i'));

            try {
                $this->pingSiteMapGoogle();
            } catch (\Exception $e) {
                report($e);
                $this->error($e->getMessage());
            }

            try {
                $this->submitUrlBing();
            } catch (\Exception $e) {
                report($e);
                $this->error($e->getMessage());
            }
        }

        return self::SUCCESS;
    }

    protected function pingSiteMapGoogle(): void
    {
        $sitemap = 'https://www.google.com/ping?sitemap=' . url('sitemap.xml');

        $response = $this->client()->get($sitemap);

        if ($response->getStatusCode() == 200) {
            $this->info('Ping site map successfull.');
        }
    }

    protected function submitUrlBing(): void
    {
        $apiKey = $this->getBingKey();
        if (empty($apiKey)) {
            return;
        }

        $lastId = get_config('jw_last_bing_submit_id', 0);

        $links = Post::wherePublish()
            ->where('id', '>', $lastId)
            ->orderBy('id', 'asc')
            ->limit(100)
            ->get();

        if ($links->isEmpty()) {
            return;
        }

        $urls = $links->map(
            function ($item) {
                return [
                    'url' => $item->getLink()
                ];
            }
        )
        ->pluck('url')
        ->toArray();

        $url = config('app.url');

        $response = $this->client()->post(
            'https://ssl.bing.com/webmaster/api.svc/json/SubmitUrlbatch?apikey=' . $apiKey,
            [
                'headers' => [
                    'Accept' => "application/json",
                    'Content-Type' => "application/json"
                ],
                'json' => [
                    'siteUrl' => $url,
                    'urlList' => $urls
                ]
            ]
        );

        if ($response->getStatusCode() == 200) {
            $this->info('Submit url Bing successfull.');

            set_config('jw_last_bing_submit_id', $links->last()->id);
        }
    }

    protected function checkSubmitDate(): bool
    {
        $lastPing = get_config('jw_last_seo_ping');

        $yesterday = Carbon::now()->subDay()->format('Y-m-d H:i');

        return empty($lastPing) || $lastPing <= $yesterday;
    }

    protected function getBingKey(): string
    {
        return get_config('jw_bing_api_key');
    }

    protected function client(): Client
    {
        return new Client(['timeout' => 10]);
    }
}
