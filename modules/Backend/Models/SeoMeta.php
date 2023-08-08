<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Models;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Seo\Models\SeoMeta
 *
 * @property int $id
 * @property string $object_type
 * @property int $object_id
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoMeta whereObjectType($value)
 * @mixin \Eloquent
 */
class SeoMeta extends Model
{
    public $timestamps = false;

    protected $table = 'seo_metas';
    protected $guarded = ['id'];

    /**
     * @param Model $model
     * @return SeoMeta|null
     */
    public static function findByModel(Model $model)
    {
        if ($model instanceof Post) {
            return self::where('object_type', '=', 'posts')
                ->where('object_id', '=', $model->id)
                ->first();
        }

        if ($model instanceof Taxonomy) {
            return self::where('object_type', '=', 'taxonomies')
                ->where('object_id', '=', $model->id)
                ->first();
        }

        return null;
    }
}
