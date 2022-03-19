<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Models;

/**
 * Juzaweb\Models\Language
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $code
 * @property string $name
 * @property bool $default
 * @property int|null $site_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 */
class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = [
        'code',
        'name',
        'default'
    ];

    protected $casts = [
        'default' => 'bool'
    ];

    public static function existsCode($code)
    {
        return Language::whereCode($code)->exists();
    }

    public static function setDefault($code)
    {
        $language = Language::whereCode($code)->firstOrFail();
        $language->update([
            'default' => true
        ]);

        Language::where('code', '!=', $code)
            ->where('default', '=', true)
            ->update([
                'default' => false
            ]);

        set_config('language', $language->code);
    }

    public function isDefault()
    {
        return $this->default;
    }
}
