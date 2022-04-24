<?php

namespace Juzaweb\Backend\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Resource;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Facades\GlobalData;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\Theme\PostTypeMenuBox;
use Juzaweb\CMS\Support\Theme\TaxonomyMenuBox;
use Juzaweb\Frontend\Http\Controllers\PostController;
use Juzaweb\Frontend\Http\Controllers\TaxonomyController;

trait HookActionRegister
{
    /**
     * JUZAWEB CMS: Registers a post type.
     * @param string $key (Required) Post type key. Must not exceed 20 characters
     * @param array $args Array of arguments for registering a post type.
     *
     * @throws \Exception
     */
    public function registerPostType($key, $args = [])
    {
        if (empty($args['label'])) {
            throw new \Exception('Post type label is required.');
        }

        $args = array_merge(
            [
                'model' => Post::class,
                'description' => '',
                'priority' => 20,
                'show_in_menu' => true,
                'rewrite' => true,
                'taxonomy_rewrite' => true,
                'menu_box' => true,
                'menu_position' => 20,
                'callback' => PostController::class,
                'menu_icon' => 'fa fa-list-alt',
                'supports' => [],
                'metas' => [],
            ],
            $args
        );

        $args['key'] = $key;
        $args['singular'] = Str::singular($key);
        $args['model_key'] = str_replace('\\', '_', $args['model']);

        $args = new Collection($args);
        GlobalData::set('post_types.' . $args->get('key'), $args);

        if ($args->get('show_in_menu')) {
            $this->registerMenuPostType($key, $args);
        }

        if ($args->get('menu_box')) {
            $this->registerMenuBox(
                'post_type_' . $key,
                [
                    'title' => $args->get('label'),
                    'group' => 'post_type',
                    'menu_box' => new PostTypeMenuBox($key, $args),
                    'priority' => 10,
                ]
            );
        }

        $supports = $args->get('supports', []);
        if (in_array('category', $supports)) {
            $this->registerTaxonomy(
                'categories',
                $key,
                [
                    'label' => trans('cms::app.categories'),
                    'priority' => $args->get('priority') + 5,
                    'menu_position' => 4,
                    'show_in_menu' => $args->get('show_in_menu'),
                    'rewrite' => $args->get('taxonomy_rewrite'),
                ]
            );
        }

        if (in_array('tag', $args['supports'])) {
            $this->registerTaxonomy(
                'tags',
                $key,
                [
                    'label' => trans('cms::app.tags'),
                    'priority' => $args->get('priority') + 6,
                    'menu_position' => 15,
                    'menu_box' => false,
                    'show_in_menu' => $args->get('show_in_menu'),
                    'rewrite' => $args->get('taxonomy_rewrite'),
                    'supports' => [],
                ]
            );
        }

        if ($args->get('rewrite')) {
            $this->registerPermalink(
                $key,
                [
                    'label' => $args->get('label'),
                    'base' => $args->get('singular'),
                    'priority' => $args->get('priority'),
                    'callback' => $args->get('callback'),
                    'post_type' => $key,
                ]
            );
        }
    }

    /**
     * Register menu box
     *
     * @param string $key
     * @param array $args
     */
    public function registerMenuBox($key, $args = [])
    {
        $opts = [
            'title' => '',
            'key' => $key,
            'group' => '',
            'menu_box' => '',
            'priority' => 20,
        ];

        $item = array_merge($opts, $args);

        GlobalData::set('menu_boxs.' . $key, new Collection($item));
    }

    /**
     * JUZAWEB CMS: Creates or modifies a taxonomy object.
     * @param string $taxonomy (Required) Taxonomy key, must not exceed 32 characters.
     * @param array|string $objectType
     * @param array $args (Optional) Array of arguments for registering a post type.
     * @return void
     *
     * @throws \Exception
     */
    public function registerTaxonomy($taxonomy, $objectType, $args = [])
    {
        $objectTypes = is_string($objectType) ? [$objectType] : $objectType;

        foreach ($objectTypes as $objectType) {
            $type = Str::singular($objectType);
            $menuSlug = 'taxonomy.' . $type . '.' . $taxonomy;

            $opts = [
                'label_type' => ucfirst($type) .' '. $args['label'],
                'priority' => 20,
                'hierarchical' => false,
                'parent' => 'post-type.' . $objectType,
                'menu_slug' => $menuSlug,
                'menu_position' => 20,
                'model' => Taxonomy::class,
                'menu_icon' => 'fa fa-list',
                'show_in_menu' => true,
                'menu_box' => true,
                'rewrite' => true,
                'supports' => [
                    'hierarchical',
                ],
            ];

            $args['type'] = $type;
            $args['post_type'] = $objectType;
            $args['taxonomy'] = $taxonomy;
            $args['singular'] = Str::singular($taxonomy);
            $args['key'] = $type . '_' . $taxonomy;

            $argsCollection = new Collection(array_merge($opts, $args));

            GlobalData::set('taxonomies.' . $objectType.'.'.$taxonomy, $argsCollection);

            if ($argsCollection->get('show_in_menu')) {
                $this->addAdminMenu(
                    $argsCollection->get('label'),
                    $menuSlug,
                    [
                        'icon' => $argsCollection->get('menu_icon', 'fa fa-list'),
                        'parent' => $argsCollection->get('parent'),
                        'position' => $argsCollection->get('menu_position'),
                    ]
                );
            }

            if ($argsCollection->get('rewrite')) {
                $this->registerPermalink(
                    $argsCollection->get('taxonomy'),
                    [
                        'label' => $argsCollection->get('label'),
                        'base' => $argsCollection->get('singular'),
                        'priority' => $argsCollection->get('priority'),
                        'callback' => TaxonomyController::class,
                    ]
                );
            }

            if ($argsCollection->get('menu_box')) {
                $this->registerMenuBox(
                    $objectType . '_' . $taxonomy,
                    [
                        'title' => $argsCollection->get('label'),
                        'group' => 'taxonomy',
                        'priority' => 15,
                        'menu_box' => new TaxonomyMenuBox(
                            $argsCollection->get('key'),
                            $argsCollection
                        ),
                    ]
                );
            }
        }
    }

    /**
     * Registers menu item in menu builder.
     *
     * @param string $key
     * @param array $args
     * @throws \Exception
     */
    public function registerPermalink($key, $args = [])
    {
        if (empty($args['label'])) {
            throw new \Exception('Permalink args label is required');
        }

        if (empty($args['base'])) {
            throw new \Exception('Permalink args default_base is required');
        }

        $args = new Collection(
            array_merge(
                [
                    'label' => '',
                    'base' => '',
                    'key' => $key,
                    'callback' => '',
                    'post_type' => '',
                    'position' => 20,
                ],
                $args
            )
        );

        GlobalData::set('permalinks.' . $key, new Collection($args));
    }

    public function registerResource($key, $postType = null, $args = [])
    {
        if (empty($args['label'])) {
            throw new \Exception('Post Resource Label is required.');
        }

        if (empty($postType)) {
            if ($menu = Arr::get($args, 'menu', [])) {
                $menu = array_merge(
                    [
                        'icon' => 'fa fa-list-ul',
                        'parent' => null,
                        'position' => 20,
                    ],
                    Arr::get($args, 'menu', [])
                );

                $menuKey = "resources.{$key}";

                $this->addAdminMenu($args['label'], $menuKey, $menu);
            }
        }

        unset($args['menu']);

        $args = array_merge(
            [
                'key' => $key,
                'model' => Resource::class,
                'label' => '',
                'label_action' => $args['label'],
                'description' => '',
                'post_type' => $postType,
                'priority' => 20,
                'supports' => [],
                'metas' => [],
            ],
            $args
        );

        $args = new Collection($args);

        GlobalData::set('resources.' . $args->get('key'), $args);
    }

    public function registerConfig(array $keys)
    {
        $configs = GlobalData::get('configs');

        GlobalData::set('configs', array_merge($keys, $configs));
    }

    public function registerAdminPage(string $key, array $args)
    {
        if (empty($args['title'])) {
            throw new \Exception('Label Admin Page is required.');
        }

        $defaults = [
            'key' => $key,
            'title' => '',
            'menu' => [
                'icon' => 'fa fa-list',
                'position' => 30,
            ]
        ];

        $args = array_merge($defaults, $args);
        $args = new Collection($args);

        $this->addAdminMenu(
            $args['title'],
            $key,
            $args['menu']
        );

        GlobalData::set('admin_pages.' . $key, $args);
    }

    public function registerAdminAjax($key, $args = [])
    {
        $defaults = [
            'callback' => '',
            'method' => 'GET',
            'key' => $key,
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('admin_ajaxs.' . $key, new Collection($args));
    }

    public function registerNavMenus($locations = [])
    {
        foreach ($locations as $key => $location) {
            GlobalData::set(
                'nav_menus.' . $key,
                new Collection(
                    [
                        'key' => $key,
                        'location' => $location,
                    ]
                )
            );
        }
    }

    public function registerEmailHook($key, $args = [])
    {
        $defaults = [
            'label' => '',
            'key' => $key,
            'params' => [],
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('email_hooks.' . $key, new Collection($args));
    }

    public function registerSidebar($key, $args = [])
    {
        $defaults = [
            'label' => '',
            'key' => $key,
            'description' => '',
            'before_widget' => '',
            'after_widget' => '',
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('sidebars.' . $key, new Collection($args));
    }

    public function registerWidget($key, $args = [])
    {
        $defaults = [
            'label' => '',
            'description' => '',
            'key' => $key,
            'widget' => '',
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('widgets.' . $key, new Collection($args));
    }

    public function registerPageBlock($key, $args = [])
    {
        $defaults = [
            'label' => '',
            'description' => '',
            'key' => $key,
            'block' => '',
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('page_blocks.' . $key, new Collection($args));
    }

    public function registerFrontendAjax($key, $args = [])
    {
        $defaults = [
            'callback' => '',
            'auth' => false,
            'key' => $key,
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('frontend_ajaxs.' . $key, new Collection($args));
    }

    public function registerThemeTemplate($key, $args = [])
    {
        $defaults = [
            'key' => $key,
            'name' => '',
            'view' => '',
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('templates.' . $key, new Collection($args));
    }

    public function registerPackageModule($key, $args = [])
    {
        $defaults = [
            'key' => $key,
            'name' => '',
            'model' => User::class,
            'configs' => [],
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('package_modules.' . $key, new Collection($args));
    }

    public function registerThemeSetting($name, $label, $args = [])
    {
        $args = [
            'name' => $name,
            'label' => $label,
            'data' => $args
        ];

        GlobalData::set('theme_settings.' . $name, new Collection($args));
    }

    /**
     * @param string $key
     * @param Collection $args
     */
    protected function registerMenuPostType($key, $args)
    {
        $supports = $args->get('supports', []);
        $prefix = 'post-type.';

        $this->addAdminMenu(
            $args->get('label'),
            $prefix . $key,
            [
                'icon' => $args->get('menu_icon', 'fa fa-edit'),
                'position' => $args->get('menu_position', 20),
            ]
        );

        $this->addAdminMenu(
            trans('cms::app.all') . ' '. $args->get('label'),
            $prefix . $key,
            [
                'icon' => 'fa fa-list-ul',
                'position' => 2,
                'parent' => $prefix . $key,
            ]
        );

        $this->addAdminMenu(
            trans('cms::app.add_new'),
            $prefix . $key . '.create',
            [
                'icon' => 'fa fa-plus',
                'position' => 3,
                'parent' => $prefix . $key,
            ]
        );

        if (in_array('comment', $supports)) {
            $this->addAdminMenu(
                trans('cms::app.comments'),
                $prefix . $args->get('singular') . '.comments',
                [
                    'icon' => 'fa fa-comments',
                    'position' => 20,
                    'parent' => $prefix . $key,
                ]
            );
        }
    }
}
