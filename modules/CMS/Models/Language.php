<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Models;

use Illuminate\Database\Eloquent\Collection;
use Juzaweb\CMS\Traits\QueryCache\QueryCacheable;

/**
 * Juzaweb\CMS\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property bool $default
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $site_id
 */
class Language extends Model
{
    use QueryCacheable;
    public string $cachePrefix = 'languages_';

    protected $table = 'languages';
    protected $fillable = [
        'code',
        'name',
        'default'
    ];

    protected $casts = [
        'default' => 'bool'
    ];

    public static function existsCode($code): bool
    {
        return Language::whereCode($code)->exists();
    }

    public static function setDefault($code)
    {
        $language = Language::whereCode($code)->firstOrFail();
        $language->update(
            [
                'default' => true
            ]
        );

        Language::where('code', '!=', $code)
            ->where('default', '=', true)
            ->update(
                [
                    'default' => false
                ]
            );

        set_config('language', $language->code);
    }

    public static function languages(): Collection
    {
        return Language::cacheFor(config('juzaweb.performance.query_cache.lifetime'))
            ->all()
            ->keyBy('code');
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    protected function getCacheBaseTags(): array
    {
        return [
            'languages',
        ];
    }
}
