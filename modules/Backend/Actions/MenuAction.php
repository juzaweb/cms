<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Actions;

use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\Notification;
use Juzaweb\CMS\Support\Theme\CustomMenuBox;
use Juzaweb\CMS\Support\Updater\CmsUpdater;
use Juzaweb\CMS\Version;
use Juzaweb\Frontend\Http\Controllers\PageController;
use Juzaweb\Frontend\Http\Controllers\PostController;

class MenuAction extends Action
{
    public function handle()
    {
        $this->addAction(self::INIT_ACTION, [$this, 'addDatatableSearchFieldTypes']);
        $this->addAction(self::INIT_ACTION, [$this, 'addPostTypes']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addBackendMenu']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addSettingPage']);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addAdminScripts'], 10);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addAdminStyles'], 10);
        $this->addAction(self::INIT_ACTION, [$this, 'addMenuBoxs'], 50);
        $this->addAction(self::BACKEND_CALL_ACTION, [$this, 'addTaxonomiesForm']);
        $this->addAction(self::INIT_ACTION, [$this, 'registerEmailHooks']);
        $this->addAction(self::BACKEND_INIT, [$this, 'checkAndNotifyUpdate']);
    }

    public function addBackendMenu()
    {
        HookAction::addAdminMenu(
            trans('cms::app.dashboard'),
            'dashboard',
            [
                'icon' => 'fa fa-dashboard',
                'position' => 1,
            ]
        );

        if (config('juzaweb.plugin.enable_upload')) {
            HookAction::addAdminMenu(
                trans('cms::app.dashboard'),
                'dashboard',
                [
                    'icon' => 'fa fa-dashboard',
                    'position' => 1,
                    'parent' => 'dashboard',
                ]
            );

            HookAction::addAdminMenu(
                trans('cms::app.updates'),
                'updates',
                [
                    'icon' => 'fa fa-arrow-circle-o-up',
                    'position' => 1,
                    'parent' => 'dashboard',
                ]
            );
        }

        HookAction::addAdminMenu(
            trans('cms::app.media'),
            'media',
            [
                'icon' => 'fa fa-photo',
                'position' => 2,
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.appearance'),
            'appearance',
            [
                'icon' => 'fa fa-paint-brush',
                'position' => 40,
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.themes'),
            'themes',
            [
                'icon' => 'fa fa-paint-brush',
                'position' => 1,
                'parent' => 'appearance',
                'permissions' => [
                    'themes.index',
                    'themes.edit',
                    'themes.create',
                    'themes.delete',
                ],
            ]
        );

        if (config('juzaweb.theme.enable_upload')) {
            HookAction::addAdminMenu(
                trans('cms::app.add_new'),
                'theme.install',
                [
                    'icon' => 'fa fa-plus',
                    'position' => 1,
                    'parent' => 'appearance',
                    'permissions' => [
                        'themes.create',
                    ],
                ]
            );

            HookAction::registerAdminPage(
                'theme.editor',
                [
                    'title' => trans('cms::app.editor'),
                    'menu' => [
                        'icon' => 'fa fa-plus',
                        'position' => 99,
                        'parent' => 'appearance',
                        'permissions' => [
                            'themes.edit',
                        ],
                    ]
                ]
            );
        }

        HookAction::addAdminMenu(
            trans('cms::app.widgets'),
            'widgets',
            [
                'icon' => 'fa fa-list',
                'position' => 2,
                'parent' => 'appearance',
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.menus'),
            'menus',
            [
                'icon' => 'fa fa-list',
                'position' => 2,
                'parent' => 'appearance',
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.setting'),
            'theme.setting',
            [
                'icon' => 'fa fa-cogs',
                'position' => 50,
                'parent' => 'appearance',
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.reading'),
            'reading',
            [
                'icon' => 'fa fa-book',
                'position' => 10,
                'parent' => 'setting',
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.permalinks'),
            'permalinks',
            [
                'icon' => 'fa fa-link',
                'position' => 15,
                'parent' => 'setting',
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.plugins'),
            'plugins',
            [
                'icon' => 'fa fa-plug',
                'position' => 50,
            ]
        );

        if (config('juzaweb.plugin.enable_upload')) {
            HookAction::addAdminMenu(
                trans('cms::app.plugins'),
                'plugins',
                [
                    'icon' => 'fa fa-plug',
                    'position' => 1,
                    'parent' => 'plugins',
                    'permissions' => [
                        'plugins.index',
                        'plugins.edit',
                        'plugins.create',
                        'plugins.delete',
                    ],
                ]
            );

            HookAction::addAdminMenu(
                trans('cms::app.add_new'),
                'plugin.install',
                [
                    'icon' => 'fa fa-plus',
                    'position' => 1,
                    'parent' => 'plugins',
                    'permissions' => [
                        'plugins.create',
                    ],
                ]
            );

            HookAction::registerAdminPage(
                'plugin.editor',
                [
                    'title' => trans('cms::app.editor'),
                    'menu' => [
                        'icon' => 'fa fa-plus',
                        'position' => 99,
                        'parent' => 'plugins',
                        'permissions' => [
                            'plugins.edit',
                        ],
                    ]
                ]
            );
        }

        HookAction::addAdminMenu(
            trans('cms::app.setting'),
            'setting',
            [
                'icon' => 'fa fa-cogs',
                'position' => 70,
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.managements'),
            'managements',
            [
                'icon' => 'fa fa-cogs',
                'position' => 75,
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.general_setting'),
            'setting.system',
            [
                'icon' => 'fa fa-cogs',
                'position' => 1,
                'parent' => 'setting',
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.users'),
            'users',
            [
                'icon' => 'fa fa-user-circle-o',
                'position' => 40,
                'parent' => 'managements',
                'permissions' => [
                    'users.index',
                    'users.edit',
                    'users.create',
                    'users.delete',
                ],
            ]
        );

        HookAction::addAdminMenu(
            trans('cms::app.email_templates'),
            'email-template',
            [
                'icon' => 'fa fa-envelope',
                'position' => 50,
                'parent' => 'managements',
                'permissions' => [
                    'email_templates.index',
                    'email_templates.edit',
                    'email_templates.create',
                    'email_templates.delete',
                ],
            ]
        );

        if (!config('network.enable')) {
            HookAction::addAdminMenu(
                trans('cms::app.email_logs'),
                'logs.email',
                [
                    'icon' => 'fa fa-cogs',
                    'position' => 51,
                    'parent' => 'managements',
                ]
            );
        }
    }

    public function addSettingPage()
    {
        HookAction::addSettingForm(
            'general',
            [
                'name' => trans('cms::app.general_setting'),
                'view' => 'cms::backend.setting.system.form.general',
                'priority' => 1,
            ]
        );

        HookAction::addSettingForm(
            'email',
            [
                'name' => trans('cms::app.email_setting'),
                'view' => 'cms::backend.email.setting',
                'header' => false,
                'footer' => false,
                'priority' => 50,
            ]
        );
    }

    public function addPostTypes()
    {
        $templates = ThemeLoader::getTemplates(jw_current_theme());
        $data = [
            'options' => ['' => trans('cms::app.choose_template')],
        ];

        foreach ($templates as $key => $template) {
            $data['options'][$key] = [
                'label' => $template['label'],
                'data' => [
                    'has-block' => ($template['blocks'] ?? 0) ? 1 : 0
                ],
            ];
        }

        HookAction::registerPostType(
            'pages',
            [
                'label' => trans('cms::app.pages'),
                'model' => Post::class,
                'menu_icon' => 'fa fa-edit',
                'rewrite' => false,
                'callback' => PageController::class,
                'metas' => [
                    'template' => [
                        'type' => 'select',
                        'label' => trans('cms::app.template'),
                        'sidebar' => true,
                        'data' => $data,
                    ],
                    'block_content' => [
                        'visible' => false,
                        'sidebar' => true,
                    ]
                ]
            ]
        );

        HookAction::registerPostType(
            'posts',
            [
                'label' => trans('cms::app.posts'),
                'model' => Post::class,
                'menu_icon' => 'fa fa-edit',
                'menu_position' => 15,
                'callback' => PostController::class,
                'supports' => [
                    'category',
                    'tag',
                    'comment',
                ],
            ]
        );
    }

    public function addMenuBoxs()
    {
        HookAction::registerMenuBox(
            'custom_url',
            [
                'title' => trans('cms::app.custom_url'),
                'group' => 'custom',
                'menu_box' => new CustomMenuBox(),
            ]
        );
    }

    public function addTaxonomiesForm()
    {
        $types = HookAction::getPostTypes();
        foreach ($types as $key => $type) {
            add_action(
                "post_type.{$key}.form.right",
                function ($model) use ($key) {
                    echo view(
                        'cms::components.taxonomies',
                        [
                            'postType' => $key,
                            'model' => $model,
                        ]
                    )->render();
                }
            );
        }
    }

    public function addAdminScripts()
    {
        $ver = Version::getVersion();
        HookAction::enqueueScript('core-vendor', 'jw-styles/juzaweb/js/vendor.min.js', $ver);
        HookAction::enqueueScript('core-backend', 'jw-styles/juzaweb/js/backend.min.js', $ver);
        HookAction::enqueueScript('core-tinymce', 'jw-styles/juzaweb/tinymce/tinymce.min.js', $ver);
        HookAction::enqueueScript('core-custom', 'jw-styles/juzaweb/js/custom.min.js', $ver);
    }

    public function addAdminStyles()
    {
        $ver = Version::getVersion();
        HookAction::enqueueStyle('core-vendor', 'jw-styles/juzaweb/css/vendor.min.css', $ver);
        HookAction::enqueueStyle('core-backend', 'jw-styles/juzaweb/css/backend.min.css', $ver);
        HookAction::enqueueStyle('core-custom', 'jw-styles/juzaweb/css/custom.min.css', $ver);
    }

    public function addDatatableSearchFieldTypes()
    {
        $this->addFilter(
            Action::DATATABLE_SEARCH_FIELD_TYPES_FILTER,
            function ($items) {
                $items['text'] = [
                    'view' => view('cms::components.datatable.text_field'),
                ];

                $items['select'] = [
                    'view' => view('cms::components.datatable.select_field'),
                ];

                $items['taxonomy'] = [
                    'view' => view('cms::components.datatable.taxonomy_field'),
                ];

                return $items;
            }
        );
    }

    public function registerEmailHooks()
    {
        HookAction::registerEmailHook(
            'register_success',
            [
                'label' => trans('cms::app.registered_success'),
                'params' => [
                    'name' => trans('cms::app.user_name'),
                    'email' => trans('cms::app.user_email'),
                    'verifyToken' => trans('cms::app.verify_token'),
                ],
            ]
        );
    }

    public function checkAndNotifyUpdate(): void
    {
        $key = cache_prefix('check_cms_update');
        if (Cache::store('file')->has($key)) {
            return;
        }

        $updater = app(CmsUpdater::class);
        $currentVersion = $updater->getCurrentVersion();

        try {
            $versionAvailable = $updater->getVersionAvailable();
        } catch (\Exception $e) {
            report($e);
            $versionAvailable = $currentVersion;
        }

        if (version_compare($versionAvailable, $currentVersion, '>')) {
            $notify = new Notification();
            $notify->setUsers(
                User::where('is_admin', 1)
                    ->active()
                    ->get()
            );
            $notify->setSubject('New Version CMS Available !');
            $notify->setBody('CMS has a new version, update now!');
            $notify->setUrl(route('admin.update'));
            $notify->send();
            Cache::store('file')->forever($key, $versionAvailable);
        } else {
            Cache::store('file')->put($key, 1, 3600);
        }
    }
}
