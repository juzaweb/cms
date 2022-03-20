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
