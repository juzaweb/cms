<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Seo;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\CMS\Models\Model;
use Juzaweb\Seo\Http\Controllers\SeoController;
use Juzaweb\Seo\Models\SeoMeta;

class SeoAction extends Action
{
    public function handle()
    {
        $this->addAction(
            Action::POSTS_FORM_LEFT_ACTION,
            [$this, 'addFormSeo']
        );

        $this->addAction(
            Action::BACKEND_CALL_ACTION,
            [$this, 'addAjaxs']
        );

        /*$this->addAction(
            Action::FRONTEND_HEADER_ACTION,
            [$this, 'addMetaHeader']
        );*/
    }

    public function addAjaxs()
    {
        HookAction::registerAdminAjax(
            'seo-content',
            [
                'callback' => [SeoController::class, 'getStringRaw'],
                'method' => 'post'
            ]
        );
    }

    public function addFormSeo(Model $model)
    {
        $data = SeoMeta::findByModel($model);

        echo e(
            view(
                'jseo::form',
                compact(
                    'model',
                    'data'
                )
            )
        );
    }

    public function addMetaHeader()
    {
        $taxonomy = '';

        echo e(
            view(
                'jseo::fe_header',
                compact(
                    'taxonomy'
                )
            )
        );
    }
}
