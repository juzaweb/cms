<?php

namespace Juzaweb\Crawler\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Juzaweb\Crawler\Helpers\Converter\BBCodeToHtml;
use Juzaweb\Crawler\Helpers\Leech\LeechComponent;
use Juzaweb\Crawler\Helpers\PostImport;
use Juzaweb\Crawler\Models\CrawContent;
use Juzaweb\Crawler\Models\CrawLink;
use Juzaweb\Crawler\Models\CrawTemplate;
use Juzaweb\EmailMarketing\Traits\CommandSlotTrait;

class CrawContentCommand extends Command
{
    use CommandSlotTrait;

    protected $signature = 'crawler:content';
    protected $slot = 1;

    public function handle()
    {
        $slot = $this->getSlot($this->signature, $this->slot);
        if (empty($slot)) {
            return self::SUCCESS;
        }

        $query = CrawLink::with(
            [
                'template' => function ($q) {
                    $q->withoutGlobalScopes();
                }
            ]
        )
            ->where('status', '=', CrawLink::STATUS_ACTIVE)
            ->inRandomOrder();

        /**
         * @var CrawLink[] $links
         */
        $links = $query->limit(1)->get();

        foreach ($links as $link) {
            $this->crawContentByLink($link);

            sleep(2);
        }

        $slot->delete();

        return self::SUCCESS;
    }

    protected function crawContentByLink(CrawLink $link)
    {
        $link->update(
            [
                'status' => CrawLink::STATUS_PROCESSING,
            ]
        );
        /**
         * @var CrawTemplate $template
         */
        $template = $link->template;
        $template->load(['components', 'removes']);

        DB::beginTransaction();
        try {
            $leech = new LeechComponent(
                $link->url,
                $template->components,
                $template->removes
            );

            $components = $leech->leech();

            if (empty($components)) {
                $link->update([
                    'status' => CrawLink::STATUS_ERROR,
                    'error' => ['Cannot get components.'],
                ]);

                DB::commit();
                return;
            }

            $title = map_crawler_params(
                $template->crawler_title,
                $components
            );

            $thumbnail = map_crawler_params(
                $template->crawler_thumbnail,
                $components
            );

            $content = map_crawler_params(
                $template->crawler_content,
                $components
            );

            $title = html_entity_decode($title);

            if ($thumbnail && !is_url($thumbnail)) {
                $thumbnail = get_full_url(
                    $thumbnail,
                    base_domain($link->url)
                );
            }

            CrawContent::updateOrCreate(
                [
                    'link_id' => $link->id
                ],
                [
                    'url' => $link->url,
                    'thumbnail' => $thumbnail,
                    'components' => $components,
                    'lang' => $template->lang,
                    'template_id' => $template->id,
                    'link_id' => $link->id,
                    'page_id' => $link->page_id,
                    'category_ids' => $link->category_ids,
                    'crawler_thumbnail' => $template->crawler_thumbnail,
                    'crawler_title' => $template->crawler_title,
                    'crawler_content' => $template->crawler_content,
                    'status' => CrawContent::STATUS_ACTIVE,
                ]
            );

            $htmlToBBCode = new BBCodeToHtml($content);
            $content = $htmlToBBCode->toHtml();

            /**
             * @var PostImport $import
             */
            $import = app(PostImport::class);
            $import->import(
                [
                    'title' => $title,
                    'content' => $content,
                    'thumbnail' => $thumbnail,
                    'lang' => $template->lang,
                    'user_id' => $template->user_id,
                    'status' => $template->post_status,
                    'category_ids' => $link->category_ids,
                ]
            );

            $link->update(
                [
                    'status' => CrawLink::STATUS_DONE,
                    'error' => null,
                ]
            );

            $this->info("ADDED CONTENT: {$title}");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (config('app.debug')) {
                throw $e;
            } else {
                Log::error($e);
            }

            $link->update(
                [
                    'status' => CrawLink::STATUS_ERROR,
                    'error' => [$e->getMessage()],
                ]
            );
        }
    }
}
