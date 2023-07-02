<?php

namespace Juzaweb\Backend\Commands;

use Google\Service\Indexing;
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
        /*if (!$this->checkSubmitDate()) {
            return self::SUCCESS;
        }*/

        //set_config('jw_last_seo_ping', date('Y-m-d H:i'));

        if (get_config('jw_auto_ping_google_sitemap')) {
            try {
                $this->pingSiteMapGoogle();
            } catch (\Exception $e) {
                report($e);
                $this->error($e->getMessage());
            }
        }

        if (get_config('jw_auto_submit_url_google')) {
            try {
                for ($i = 1; $i <= 2; $i++) {
                    $this->submitUrlGoogle();

                    sleep(5);
                }
            } catch (\Exception $e) {
                report($e);
                $this->error($e->getMessage());
            }
        }

        if (get_config('jw_auto_submit_url_bing')) {
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

    protected function submitUrlGoogle(): void
    {
        $lastDate = get_config('jw_last_google_submit_date', '2000-01-01 00:00:00');
        $links = Post::wherePublish()
            ->where('updated_at', '>', $lastDate)
            ->orderBy('updated_at', 'asc')
            ->limit(100)
            ->get();

        if ($links->isEmpty()) {
            return;
        }

        $lastUpdatedAt = $links->last()->updated_at->format('Y-m-d H:i:s');

        $client = new \Google\Client();
        $client->setAuthConfig(storage_path('services/service_account.json'));
        $client->addScope('https://www.googleapis.com/auth/indexing');
        $client->setUseBatch(true);

        $service = new Indexing($client);
        $batch = $service->createBatch();

        foreach ($links as $link) {
            $this->info("=> Submiting url: ". $link->getLink(true));
            $url = new Indexing\UrlNotification();
            $url->setUrl($link->getLink(true));
            $url->setType('URL_UPDATED');
            $batch->add($service->urlNotifications->publish($url));
        }

        $batch->execute();

        set_config('jw_last_google_submit_date', $lastUpdatedAt);

        $this->info('Submit urls to Google successfull.');
    }

    protected function submitUrlBing(): void
    {
        $apiKey = $this->getBingKey();
        if (empty($apiKey)) {
            return;
        }

        $lastDate = get_config('jw_last_bing_submit_date', '2000-01-01 00:00:00');

        $links = Post::wherePublish()
            ->where('updated_at', '>', $lastDate)
            ->orderBy('updated_at', 'asc')
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
            $this->info('Submit urls to Bing successfull.');

            set_config('jw_last_bing_submit_date', $links->last()->updated_at->format('Y-m-d H:i:s'));
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
