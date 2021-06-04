<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/31/2021
 * Time: 9:48 PM
 */

namespace Mymo\PostType;

use Illuminate\Support\Arr;

class PostType
{
    /**
     * Get post type setting
     *
     * @param string|null $postType
     * @return \Illuminate\Support\Collection
     * */
    public static function getPostTypes($postType = null)
    {
        if ($postType) {
            return Arr::get(apply_filters('mymo.post_types', []), $postType);
        }

        return apply_filters('mymo.post_types', []);
    }

    public static function getTaxonomies($postType = null)
    {
        $taxonomies = collect(apply_filters('mymo.taxonomies', []));
        if (empty($taxonomies)) {
            return $taxonomies;
        }

        $taxonomies = collect($taxonomies[$postType] ?? []);
        $taxonomies = $taxonomies ?
            $taxonomies->sortBy('menu_position')
            : [];

        return $taxonomies;
    }

    /**
     * Sync taxonomies post type
     *
     * @param string $postType
     * @param \Mymo\PostType\Models\Post $model
     * @param array $attributes
     * @return void
     *
     * @throws \Exception
     */
    public static function syncTaxonomies($postType, $model, array $attributes)
    {
        $taxonomies = PostType::getTaxonomies($postType);
        foreach ($taxonomies as $taxonomy) {
            if (!Arr::has($attributes, $taxonomy->get('taxonomy'))) {
                continue;
            }

            $data = Arr::get($attributes, $taxonomy->get('taxonomy'), []);
            $model->taxonomies()
                ->where('taxonomy', '=', $taxonomy->get('singular'))
                ->sync(combine_pivot($data, [
                    'term_type' => $postType
                ]));
        }
    }
}