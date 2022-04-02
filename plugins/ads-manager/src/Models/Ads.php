<?php

namespace Juzaweb\AdsManager\Models;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Models\Model;

/**
 * Juzaweb\AdsManager\Models\Ads
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $position
 * @property string|null $body
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Ads newModelQuery()
 * @method static Builder|Ads newQuery()
 * @method static Builder|Ads query()
 * @method static Builder|Ads whereActive($value)
 * @method static Builder|Ads whereBody($value)
 * @method static Builder|Ads whereCreatedAt($value)
 * @method static Builder|Ads whereId($value)
 * @method static Builder|Ads whereName($value)
 * @method static Builder|Ads wherePosition($value)
 * @method static Builder|Ads whereSiteId($value)
 * @method static Builder|Ads whereType($value)
 * @method static Builder|Ads whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Ads extends Model
{
    const TYPE_BANNER = 'banner';
    const TYPE_HTML = 'html';

    protected $table = 'juad_ads';
    protected $fillable = [
        'name',
        'body',
        'active',
        'position'
    ];

    public static function getPositions()
    {
        return [
            'post_header' => trans('cms::app.post_header'),
            'post_footer' => trans('cms::app.post_footer'),
            'bottom_left' => trans('cms::app.bottom_left'),
            'bottom_right' => trans('cms::app.bottom_right'),
        ];
    }

    public function getBody()
    {
        switch ($this->type) {
            case Ads::TYPE_BANNER:
                return '<img src="'. upload_url($this->body) .'" />';
        }

        return $this->body;
    }

    public function getFieldName()
    {
        return 'name';
    }
}
