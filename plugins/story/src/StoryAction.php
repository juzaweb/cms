<?php

namespace Juzaweb\Story;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class StoryAction extends Action
{
    public function handle()
    {
        HookAction::addAction(self::INIT_ACTION, [$this, 'registerPostTypes']);
        HookAction::addAction(self::INIT_ACTION, [$this, 'registerResources']);
    }

    public function registerPostTypes()
    {
        HookAction::registerPostType(
            'stories',
            [
                'label' => 'Stories',
                'menu_icon' => 'fa fa-list',
                'supports' => ['category', 'tag', 'comment'],
                'metas' => [
                    'chapters' => [
                        'type' => 'text',
                        'label' => 'Total Chapter'
                    ]
                ]
            ]
        );
    }

    public function registerResources()
    {
        HookAction::registerResource(
            'chapters',
            'stories',
            [
                'label' => 'Chapters',
                'metas' => [
                'content' => [
                    'type' => 'editor',
                        'label' => 'Content'
                    ]
                ]
            ]
        );
    }
}
