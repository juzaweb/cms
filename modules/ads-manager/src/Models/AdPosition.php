<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\AdsManagement\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Juzaweb\Modules\Core\Models\Model;
use Juzaweb\Modules\Core\Traits\HasThemeField;

class AdPosition extends Model
{
    use HasThemeField;

    public $timestamps = false;

    protected $table = 'ad_positions';

    protected $fillable = [
        'position',
        'theme',
        'positionable_type',
        'positionable_id',
    ];

    public function positionable(): MorphTo
    {
        return $this->morphTo();
    }
}
