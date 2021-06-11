<?php
/**
 * @package    tadcms\tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/3/2021
 * Time: 11:05 AM
 */

namespace Mymo\Core\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait PostTypeHookAction
{
    /**
     * TAD CMS: Creates or modifies a taxonomy object.
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
            $opts = [
                'label' => '',
                'label_type' => ucfirst($type) .' '. $args['label'],
                'description' => '',
                'hierarchical' => false,
                'parent' => $objectType,
                'menu_slug' => $type . '.' . $taxonomy,
                'menu_position' => 20,
                'menu_icon' => 'fa fa-list',
                'supports' => [
                    'thumbnail',
                    'hierarchical'
                ],
            ];

            $iargs = $args;
            $iargs['type'] = $type;
            $iargs['post_type'] = $objectType;
            $iargs['taxonomy'] = $taxonomy;
            $iargs['singular'] = Str::singular($taxonomy);
            $iargs = collect(array_merge($opts, $iargs));

            add_filters('mymo.taxonomies', function ($items) use ($taxonomy, $objectType, $iargs) {
                $items[$objectType][$taxonomy] = $iargs;
                return $items;
            });

            $this->addAdminMenu(
                $iargs->get('label'),
                $iargs->get('menu_slug'),
                [
                    'icon' => $iargs->get('menu_icon', 'fa fa-list'),
                    'parent' => $iargs->get('parent'),
                    'position' => $iargs->get('menu_position')
                ]
            );

            $this->registerPermalink($taxonomy, [
                'label' => $iargs->get('label'),
                'base' => $iargs->get('singular'),
                'callback' => 'Mymo\\Theme\\Http\\Controllers\\TaxonomyController'
            ]);
        }
    }

    /**
     * TAD CMS: Registers a post type.
     * @param string $key (Required) Post type key. Must not exceed 20 characters
     * @param array $args Array of arguments for registering a post type.
     *
     * @throws \Exception
     */
    public function registerPostType($key, $args = [])
    {
        if (empty($args['model'])) {
            throw new \Exception('Post type model is required. E.x: \\Mymo\\PostType\\Models\\Post.');
        }

        $args = array_merge([
            'label' => '',
            'description' => '',
            'menu_position' => 20,
            'menu_icon' => 'fa fa-list-alt',
            'supports' => [],
        ], $args);

        $args['key'] = $key;
        $args['singular'] = Str::singular($key);
        $args = collect($args);

        add_filters('mymo.post_types', function ($items) use ($args) {
            $items[$args->get('key')] = $args;
            return $items;
        });

        $this->addAdminMenu(
            $args->get('label'),
            $key,
            [
                'icon' => $args->get('menu_icon', 'fa fa-edit'),
                'position' => $args->get('menu_position', 20)
            ]
        );

        $this->addAdminMenu(
            trans('mymo_core::app.all') . ' '. $args->get('label'),
            $key,
            [
                'icon' => 'fa fa-list-ul',
                'position' => 2,
                'parent' => $key,
            ]
        );

        $this->addAdminMenu(
            trans('mymo_core::app.add_new'),
            $key . '.create',
            [
                'icon' => 'fa fa-plus',
                'position' => 3,
                'parent' => $key,
            ]
        );

        $supports = $args->get('supports', []);
        if (in_array('category', $supports)) {
            $this->registerTaxonomy('categories', $key, [
                'label' => trans('mymo_core::app.categories'),
                'menu_position' => 4,
            ]);
        }

        if (in_array('tag', $args['supports'])) {
            $this->registerTaxonomy('tags', $key, [
                'label' => trans('mymo_core::app.tags'),
                'menu_position' => 15,
                'supports' => []
            ]);
        }
    }
}
