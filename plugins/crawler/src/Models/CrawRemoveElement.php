<?php

namespace Juzaweb\Crawler\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Juzaweb\Crawler\Models\CrawRemoveElement
 *
 * @property int $id
 * @property string $element
 * @property int $template_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement query()
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement whereElement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement whereTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $index
 * @property-read \Juzaweb\Crawler\Models\CrawTemplate|null $template
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement whereIndex($value)
 * @property int $type 1: Remove all, 2: Remove html
 * @method static \Illuminate\Database\Eloquent\Builder|CrawRemoveElement whereType($value)
 */
class CrawRemoveElement extends Model
{
    protected $table = 'crawler_remove_elements';
    protected $fillable = [
        'element',
        'template_id',
        'index',
        'type',
    ];
    
    public $timestamps = false;
    
    public function template()
    {
        return $this->belongsTo(CrawTemplate::class, 'template_id', 'id');
    }
}
