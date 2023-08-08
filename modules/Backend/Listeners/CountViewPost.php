<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Listeners;

use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Events\PostViewed;
use Illuminate\Session\Store;
use Juzaweb\Backend\Models\PostView;

class CountViewPost
{
    private Store $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * @param PostViewed $event
     */
    public function handle(PostViewed $event): void
    {
        if (!$this->isPostViewed($event->post)) {
            DB::table('posts')
                ->where(['id' => $event->post->id])
                ->update(['views' => DB::raw('views + 1')]);

            $model = PostView::firstOrNew(
                [
                    'post_id' => $event->post->id,
                    'day' => date('Y-m-d'),
                ]
            );

            $model->views = empty($model->views) ? 1 : $model->views + 1;
            $model->save();

            $this->storePost($event->post);
        }
    }

    private function isPostViewed($post): bool
    {
        $viewed = $this->session->get('viewed_posts', []);

        return array_key_exists($post->id, $viewed);
    }

    private function storePost($post): void
    {
        $key = 'viewed_posts.' . $post->id;

        $this->session->put($key, 1);
    }
}
