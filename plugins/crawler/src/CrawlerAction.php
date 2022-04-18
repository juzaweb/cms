<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Crawler;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class CrawlerAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'addAddminMenu']);
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'addScriptAdmin']);
    }

    public function addScriptAdmin()
    {
        $ver = app('plugins')->find('juzaweb/crawler')->getVersion();

        HookAction::enqueueScript(
            'crawler',
            'jw-styles/plugins/juzaweb/crawler/js/crawler.js',
            $ver
        );
    }

    public function addAddminMenu()
    {
        HookAction::addAdminMenu(
            trans('crawler::content.crawler'),
            'crawler.template',
            [
                'position' => 20,
            ]
        );
    }
}
