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
 * Date: 6/8/2021
 * Time: 8:08 PM
 */

namespace Mymo\PostType\Traits;

use Illuminate\Support\Arr;
use Mymo\PostType\PostType;

trait PostTypeAble
{
    protected $postType;

    public function taxonomies()
    {
        return $this->belongsToMany('Mymo\PostType\Models\Taxonomy', 'term_taxonomies', 'term_id', 'taxonomy_id')
            ->withPivot(['term_type'])
            ->wherePivot('term_type', '=', $this->getPostType());
    }

    public function syncTaxonomies(array $attributes)
    {
        $postType = $this->getPostType();
        $taxonomies = PostType::getTaxonomies($postType);
        foreach ($taxonomies as $taxonomy) {
            if (!Arr::has($attributes, $taxonomy->get('taxonomy'))) {
                continue;
            }

            $data = Arr::get($attributes, $taxonomy->get('taxonomy'), []);
            $detachIds = $this->taxonomies()
                ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
                ->whereNotIn('id', $data)
                ->pluck('id')
                ->toArray();

            $this->taxonomies()->detach($detachIds);
            $this->taxonomies()
                ->syncWithoutDetaching(combine_pivot($data, [
                    'term_type' => $postType
                ]), ['term_type' => $postType]);
        }
    }

    protected function getPostType()
    {
        if ($this->postType) {
            return $this->postType;
        }

        return $this->getTable();
    }
}