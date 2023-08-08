<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Juzaweb\Backend\Models\Taxonomy;
use Symfony\Component\Console\Input\InputOption;

class PingFeedCommand extends Command
{
    protected $name = 'juzacms:ping-feed';

    protected $description = 'Auto ping sitemap and submit url for SEO.';

    public function handle(): void
    {
        $lastPing = get_config('juzacms_last_ping_feed_id', 0);

        $taxonomies = Taxonomy::orderBy('id', 'ASC')
            ->where('id', '>', $lastPing)
            ->limit($this->option('limit'))
            ->get();

        foreach ($taxonomies as $taxonomy) {
            $url = route('feed.taxonomy', [$taxonomy->slug]);
            $this->pingFeedGoogle($url);
            sleep(2);
        }

        set_config('juzacms_last_ping_feed_id', $taxonomies->last()->id);
    }

    protected function pingFeedGoogle(string $url): void
    {
        $sitemap = 'https://www.google.com/ping?sitemap=' . $url;

        $response = $this->client()->get($sitemap);

        if ($response->getStatusCode() == 200) {
            $this->info("Ping {$url} successfull.");
        }
    }

    protected function getOptions(): array
    {
        return [
            ['limit', null, InputOption::VALUE_REQUIRED, 'Limit ping taxonomies.', 10],
            ['preview', null, InputOption::VALUE_OPTIONAL, 'Limit ping taxonomies.', false],
        ];
    }

    protected function client(): Client
    {
        return new Client(['timeout' => 10]);
    }
}
