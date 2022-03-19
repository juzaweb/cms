<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Listeners;

use Juzaweb\Backend\Events\PostViewed;
use Illuminate\Session\Store;
use Juzaweb\Backend\Models\PostView;

class CountViewPost
{
    private $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * @param PostViewed $event
     */
    public function handle(PostViewed $event)
    {
        if (!$this->isPostViewed($event->post)) {
            $event->post->increment('views');
            $event->post->save();

            $model = PostView::firstOrNew([
                'post_id' => $event->post->id,
                'day' => date('Y-m-d'),
            ]);

            $model->views = empty($model->views) ? 1 : $model->views + 1;
            $model->save();

            $this->storePost($event->post);
        }
    }

    private function isPostViewed($post)
    {
        $viewed = $this->session->get('viewed_posts', []);

        return array_key_exists($post->id, $viewed);
    }

    private function storePost($post)
    {
        $key = 'viewed_posts.' . $post->id;

        $this->session->put($key, 1);
    }
}
