<?php

namespace Juzaweb\Crawler\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Juzaweb\Crawler\Helpers\Leech\LeechListItems;
use Juzaweb\Crawler\Models\CrawLink;
use Juzaweb\Crawler\Models\CrawTemplate;

class CrawLinkCommand extends Command
{
    protected $signature = 'crawler:link';
    
    public function handle()
    {
        $date = Carbon::now();
        $date->subMinutes(20);
        
        $query = CrawTemplate::withoutGlobalScopes()
            ->where('auto_leech', '=', 1)
            ->where('status', '=', CrawTemplate::STATUS_ACTIVE)
            ->whereHas('components')
            ->whereHas(
                'pages',
                function (Builder $q) use ($date) {
                    $ptb = $q->getModel()->getTable();
                    $q->where(
                        "{$ptb}.status",
                        '=',
                        CrawTemplate::STATUS_ACTIVE
                    );
                    $q->where(
                        "{$ptb}.crawler_date",
                        '<',
                        $date
                    );
                }
            )
            ->inRandomOrder()
            ->limit(1);
        
        $links = $query->get();

        foreach ($links as $link) {
            $page = $link->pages()
                ->where('status', '=', CrawTemplate::STATUS_ACTIVE)
                ->where('crawler_date', '<', $date)
                ->inRandomOrder()
                ->first();
            
            if (empty($page)) {
                continue;
            }
    
            $itemUrls = $this->getItemLinks(
                $page->list_url,
                $page->element_item
            );
            
            if ($page->list_url_page) {
                if ($page->next_page > 1) {
                    $crawler_url = str_replace(
                        '{page}',
                        $page->next_page,
                        $page->list_url_page
                    );

                    $itemUrls2 = $this->getItemLinks(
                        $crawler_url,
                        $page->element_item
                    );

                    if (empty($itemUrls2) || !is_array($itemUrls2)) {
                        $page->update(
                            [
                                'next_page' => 0,
                            ]
                        );
                    }

                    $itemUrls = array_merge($itemUrls, $itemUrls2);
                    $itemUrls = array_unique($itemUrls);
                }
            }
            
            if (empty($itemUrls)) {
                Log::error('Craw link ' . ($crawler_url ?? $page->list_url) . ' empty links.');
                continue;
            }

            $urls = CrawLink::whereIn('url', $itemUrls)
                ->pluck('url')
                ->toArray();

            $data = collect($itemUrls)
                ->filter(
                    function ($url) use ($urls) {
                        return is_url($url) && !in_array($url, $urls);
                    }
                )->map(
                    function ($url) use ($link, $page) {
                        return [
                            'url' => $url,
                            'template_id' => $link->id,
                            'page_id' => $page->id,
                            'category_ids' => json_encode($page->category_ids),
                        ];
                    }
                )->toArray();

            DB::beginTransaction();
            try {
                DB::table('crawler_links')->insert($data);

                $next_page = ($page->list_url_page && $page->next_page > 0) ?
                    $page->next_page + 1 :
                    ($page->next_page > 0 ? 1 : 0);

                $page->update(
                    [
                        'crawler_date' => now(),
                        'next_page' => $next_page,
                    ]
                );

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                if (config('app.debug')) {
                    throw $e;
                } else {
                    Log::error($e);
                }
            }

            $this->info('Inserted ' . count($urls) . ' urls.');
        }

        return self::SUCCESS;
    }
    
    public function getItemLinks($list_url, $element_item_url)
    {
        $split = explode('|', $element_item_url);
        $element = $split[0];
        $attr = $split[1] ?? 'href';
        
        $crawler_list = new LeechListItems($list_url, $element, $attr);
        return $crawler_list->getItems();
    }
}
