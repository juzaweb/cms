<?php
/**
 * @package    juzaweb/cms
 * @author     JuzaWeb Team
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits\HookAction;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;
use Juzaweb\API\Support\Swagger\SwaggerDocument;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\HookActions\Traits\ThemeHookAction;
use Juzaweb\CMS\Support\Registers\ResourceRegister;
use Juzaweb\CMS\Support\Theme\PostTypeMenuBox;
use Juzaweb\CMS\Support\Theme\TaxonomyMenuBox;
use Juzaweb\Frontend\Http\Controllers\PostController;
use Juzaweb\Frontend\Http\Controllers\TaxonomyController;

trait RegisterHookAction
{
    use ThemeHookAction;

    protected array $resourcePermissions = ['index', 'create', 'edit', 'delete'];

    public function registerPostType(string $key, array $args = []): void
    {
        if (empty($args['label'])) {
            throw new \RuntimeException('Post type label is required.');
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

        $this->globalData->set('post_types.' . $args->get('key'), $args);

        $this->registerResourcePermissions(
            "post-type.{$key}",
            $args->get('label')
        );

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
                    'priority' => intval($args->get('priority')) + 5,
                    'menu_position' => 4,
                    'show_in_menu' => $args->get('show_in_menu'),
                    'rewrite' => $args->get('taxonomy_rewrite'),
                ]
            );
        }

        if (in_array('tag', $supports)) {
            $this->registerTaxonomy(
                'tags',
                $key,
                [
                    'label' => trans('cms::app.tags'),
                    'priority' => intval($args->get('priority')) + 6,
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

    public function registerMenuBox(string $key, array $args = []): void
    {
        $opts = [
            'title' => '',
            'key' => $key,
            'group' => '',
            'menu_box' => '',
            'priority' => 20,
        ];

        $item = array_merge($opts, $args);

        $this->globalData->set('menu_boxs.' . $key, new Collection($item));
    }

    public function registerTaxonomy(string $taxonomy, array|string $objectType, array $args = []): void
    {
        $objectTypes = is_string($objectType) ? [$objectType] : $objectType;

        foreach ($objectTypes as $objectType) {
            $type = Str::singular($objectType);
            $menuSlug = 'taxonomy.' . $type . '.' . $taxonomy;

            $opts = [
                'label_type' => ucfirst($type) . ' ' . $args['label'],
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

            $this->globalData->set('taxonomies.' . $objectType . '.' . $taxonomy, $argsCollection);

            $this->registerResourcePermissions(
                $menuSlug,
                Str::ucfirst($type) . ' ' . $argsCollection->get('label')
            );

            if ($argsCollection->get('show_in_menu')) {
                $this->addAdminMenu(
                    $argsCollection->get('label'),
                    $menuSlug,
                    [
                        'icon' => $argsCollection->get('menu_icon', 'fa fa-list'),
                        'parent' => $argsCollection->get('parent'),
                        'position' => $argsCollection->get('menu_position'),
                        'permissions' => [
                            "{$menuSlug}.index",
                            "{$menuSlug}.create",
                            "{$menuSlug}.edit",
                            "{$menuSlug}.delete",
                        ],
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

    public function registerPermalink(string $key, array $args = []): void
    {
        if (empty($args['label'])) {
            throw new Exception('Permalink args label is required');
        }

        if (empty($args['base'])) {
            throw new Exception('Permalink args default_base is required');
        }

        $args = new Collection(
            array_merge(
                [
                    'label' => '',
                    'base' => '',
                    'key' => $key,
                    'callback' => null,
                    'post_type' => null,
                    'position' => 20,
                ],
                $args
            )
        );

        $this->globalData->set('permalinks.' . $key, new Collection($args));
    }

    public function registerResource(string $key, ?string $postType = null, ?array $args = []): void
    {
        $register = new ResourceRegister($this);

        $data = $register->make($key, $postType, $args);

        $this->globalData->set('resources.' . $data->getKey(), $data->args());
    }

    public function registerConfig(array|string $key, array $args = []): void
    {
        $configs = $this->globalData->get('configs');

        $this->globalData->set('configs', array_merge($key, $configs));
    }

    public function registerAdminPage(string $key, #[ArrayShape()] array $args): void
    {
        if (empty($args['title'])) {
            throw new Exception('Label Admin Page is required.');
        }

        $defaults = [
            'key' => $key,
            'title' => '',
            'menu' => [
                'icon' => 'fa fa-list',
                'position' => 30,
            ],
        ];

        $args = array_merge($defaults, $args);
        $args = new Collection($args);

        $this->addAdminMenu(
            $args['title'],
            $key,
            $args['menu']
        );

        $this->globalData->set('admin_pages.' . $key, $args);
    }

    public function registerAdminAjax(string $key, array $args = []): void
    {
        $defaults = [
            'callback' => '',
            'method' => 'GET',
            'key' => $key,
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('admin_ajaxs.' . $key, new Collection($args));
    }

    public function registerEmailHook(string $key, array $args = []): void
    {
        $defaults = [
            'label' => '',
            'key' => $key,
            'params' => [],
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('email_hooks.' . $key, new Collection($args));
    }

    public function registerSidebar(string $key, array $args = []): void
    {
        $defaults = [
            'label' => '',
            'key' => $key,
            'description' => '',
            'before_widget' => '',
            'after_widget' => '',
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('sidebars.' . $key, new Collection($args));
    }

    public function registerWidget(string $key, array $args = []): void
    {
        $defaults = [
            'label' => '',
            'description' => '',
            'key' => $key,
            'widget' => '',
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('widgets.' . $key, new Collection($args));
    }

    public function registerPageBlock(string $key, array $args = []): void
    {
        $defaults = [
            'label' => '',
            'description' => '',
            'key' => $key,
            'block' => '',
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('page_blocks.' . $key, new Collection($args));
    }

    public function registerPackageModule(string $key, array $args = []): void
    {
        $defaults = [
            'key' => $key,
            'name' => '',
            'model' => User::class,
            'configs' => [],
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('package_modules.' . $key, new Collection($args));
    }

    public function registerPermissionGroup(string $key, array $args = []): void
    {
        $key = str_replace(['.'], '__', $key);

        $defaults = [
            'name' => '',
            'description' => '',
            'key' => $key,
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('permission_groups.' . $key, new Collection($args));
    }

    public function registerPermission(string $key, array $args = []): void
    {
        $arrKey = str_replace(['.'], '__', $key);

        $defaults = [
            'name' => $key,
            'group' => '',
            'description' => '',
            'key' => $arrKey,
        ];

        $args = array_merge($defaults, $args);

        $args['group'] = str_replace(['.'], '__', $args['group']);

        $this->globalData->set('permissions.' . $arrKey, new Collection($args));
    }

    public function registerResourcePermissions(string $resource, string $name): void
    {
        foreach ($this->resourcePermissions as $permission) {
            $label = $permission == 'index' ? trans('cms::app.permission_manager.view_list') : $permission;
            $permission = "{$resource}.{$permission}";

            $this->registerPermissionGroup(
                $resource,
                [
                    'name' => $resource,
                    'description' => $name,
                ]
            );

            $this->registerPermission(
                $permission,
                [
                    'name' => $permission,
                    'group' => $resource,
                    'description' => Str::ucfirst($label) . " {$name}",
                ]
            );
        }
    }

    public function registerEmailTemplate(string $key, array $args = []): void
    {
        $defaults = [
            'code' => $key,
            'subject' => '',
            'body' => '',
            'params' => [],
            'email_hook' => null,
        ];

        $args = array_merge($defaults, $args);

        $this->globalData->set('email_templates.' . $key, new Collection($args));
    }

    public function registerAPIDocument(string|SwaggerDocument $key, array $args = []): void
    {
        if ($key instanceof SwaggerDocument) {
            $args = $key->toArray();
            $key = $key->getName();
        }

        $this->globalData->set("api_documents.{$key}", new Collection($args));
    }

    public function registerAPIDocumentPath(string|SwaggerDocument $key, array $args = []): void
    {
        if ($key instanceof SwaggerDocument) {
            $args = $key->toArray();
            $key = $key->getName();
        }

        $this->globalData->set("api_documents.{$key}", new Collection($args));
    }

    public function registerSettingPage(string $key, array $args = []): void
    {
        $defaults = [
            'key' => $key,
            'label' => '',
            'menu' => [
                'icon' => 'fa fa-cogs',
                'parent' => 'setting',
            ]
        ];

        $args = array_merge($defaults, $args);

        $this->addAdminMenu(
            $args['label'],
            "setting.{$key}",
            $args['menu']
        );

        $this->globalData->set('setting_pages.' . $key, new Collection($args));
    }

    /**
     * @param string $key
     * @param Collection $args
     */
    protected function registerMenuPostType(string $key, Collection $args): void
    {
        $supports = (array) $args->get('supports', []);

        $prefix = 'post-type.';

        $this->addAdminMenu(
            $args->get('label'),
            $prefix . $key,
            [
                'icon' => $args->get('menu_icon', 'fa fa-edit'),
                'position' => $args->get('menu_position', 20),
                'permissions' => [
                    "{$prefix}{$key}.index",
                    "{$prefix}{$key}.create",
                    "{$prefix}{$key}.edit",
                    "{$prefix}{$key}.delete",
                ],
            ]
        );

        $this->addAdminMenu(
            trans('cms::app.all') . ' ' . $args->get('label'),
            $prefix . $key,
            [
                'icon' => 'fa fa-list-ul',
                'position' => 2,
                'parent' => $prefix . $key,
                'permissions' => [
                    "{$prefix}{$key}.index",
                    "{$prefix}{$key}.create",
                    "{$prefix}{$key}.edit",
                    "{$prefix}{$key}.delete",
                ],
            ]
        );

        $this->addAdminMenu(
            trans('cms::app.add_new'),
            $prefix . $key . '.create',
            [
                'icon' => 'fa fa-plus',
                'position' => 3,
                'parent' => $prefix . $key,
                'permissions' => [
                    "{$prefix}{$key}.create",
                ],
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
