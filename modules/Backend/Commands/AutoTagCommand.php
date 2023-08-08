<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Juzaweb\Backend\Jobs\AutoTagJob;
use Juzaweb\Backend\Models\Post;

class AutoTagCommand extends Command
{
    protected $name = 'juza:auto-tags';

    protected int $postLimit = 500;

    public function handle(): int
    {
        $lastDate = get_config('seo_last_update_tag_date', '2000-01-01 00:00:00');
        $chunkSize = 100;

        $job = 1;
        $maxId = $this->getPostBuilder($lastDate)->skip($this->postLimit)->take(1)->value('id');

        $this->getPostBuilder($lastDate)
            ->when($maxId, fn($q) => $q->where('id', '<', $maxId))
            ->chunkById(
                $chunkSize,
                function ($rows) use (&$lastDate, &$job, $chunkSize) {
                    AutoTagJob::dispatch($lastDate, $chunkSize)
                        ->delay(Carbon::now()->addSeconds($job * 305));

                    $lastDate = $rows->last()->updated_at->format('Y-m-d H:i:s');
                    $job ++;

                    $this->info("Adding tags to post id ". $rows->last()->id);
                }
            );

        set_config('seo_last_update_tag_date', $lastDate);

        return self::SUCCESS;
    }

    private function getPostBuilder(string $lastDate): \Illuminate\Database\Eloquent\Builder
    {
        return Post::with([])->select(['id', 'updated_at'])
            ->where('status', '=', Post::STATUS_PUBLISH)
            ->where('updated_at', '>', $lastDate)
            ->whereDoesntHave('taxonomies', fn($q) => $q->where('taxonomy', 'tags'))
            ->orderBy('updated_at', 'ASC');
    }
}
