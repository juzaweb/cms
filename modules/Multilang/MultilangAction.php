<?php

namespace Juzaweb\Multilang;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\Language;

class MultilangAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addBackendMenu']);
        $this->addAction(Action::POSTS_FORM_RIGHT_ACTION, [$this, 'addSelectLangPost'], 5);
        $this->addAction(Action::INIT_ACTION, [$this, 'addConfigs']);
        $this->addFilter('post.selectFrontendBuilder', [$this, 'changeFrontendQueryBuilder']);
    }

    public function changeFrontendQueryBuilder($builder)
    {
        if ($locale = session()->get('jw_locale')) {
            $builder->where('locale', $locale);
        }

        return $builder;
    }

    public function addBackendMenu(): void
    {
        HookAction::registerAdminPage(
            'languages',
            [
                'title' => trans('cms::app.languages'),
                'menu' => [
                    'position' => 30,
                    'parent' => 'managements',
                ]
            ]
        );
    }

    public function addSelectLangPost($model): void
    {
        $default = get_config('language', 'en');
        $selected = $default;
        $languages = Language::get()->mapWithKeys(function ($item) {
            return [
                $item->code => $item->name
            ];
        });

        echo e(view(
            'mlla::select_lang',
            compact(
                'model',
                'languages',
                'selected'
            )
        ));
    }

    public function addConfigs(): void
    {
        HookAction::registerConfig(['mlla_type', 'mlla_subdomain']);
    }
}
