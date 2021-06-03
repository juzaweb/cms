<?php

namespace Mymo\PostType\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\PostType\Models\TaxonomyTranslation
 *
 * @property int $id
 * @property int $taxonomy_id
 * @property string $locale
 * @property string $name
 * @property string|null $thumbnail
 * @property string|null $description
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation whereTaxonomyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TaxonomyTranslation whereThumbnail($value)
 * @mixin \Eloquent
 */
class TaxonomyTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'taxonomy_translations';
    protected $fillable = [
        'locale',
        'taxonomy_id',
        'name',
        'thumbnail',
        'description'
    ];
}
