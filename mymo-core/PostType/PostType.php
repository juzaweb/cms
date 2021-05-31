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
     * @param string $postType
     * @return \Illuminate\Support\Collection
     * */
    public static function getSetting($postType)
    {
        return Arr::get(apply_filters('mymo.post_types', []), $postType);
    }
}