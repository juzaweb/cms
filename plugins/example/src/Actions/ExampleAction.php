<?php

namespace Juzaweb\Example\Actions;

use Juzaweb\CMS\Abstracts\Action;

class ExampleAction extends Action
{
    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'registerPostTypes']);
    }

    public function registerPostTypes()
    {
        $this->hookAction->registerPostType(
            'examples',
            [
                'label' => __('Example Post'),
                'menu_icon' => 'fa fa-list',
                'supports' => ['category', 'tag'],
                'metas' => [
                    'example' => [
                        'type' => 'text',
                        'label' => __('Example Field')
                    ],
                    'select' => [
                        'type' => 'select',
                        'label' => __('Example Select'),
                        'data' => [
                            'options' => [
                                0 => __('Disabled'),
                                1 => __('Enabled')
                            ]
                        ]
                    ]
                ],
            ]
        );

        $this->hookAction->registerTaxonomy(
            'countries',
            'examples',
            [
                'label' => __('Countries'),
                'supports' => []
            ]
        );
    }
}
