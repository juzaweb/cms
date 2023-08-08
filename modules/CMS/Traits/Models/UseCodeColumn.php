<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Traits\Models;

use Illuminate\Support\Str;

trait UseCodeColumn
{
    public static function generateCode(): string
    {
        do {
            $code = Str::random(15);
        } while (static::withoutGlobalScopes()->where('code', $code)->exists());

        return $code;
    }

    protected static function bootUseCodeColumn(): void
    {
        /**
         * Listen for the creating event on the user model.
         * Sets the 'id' to a UUID using Str::uuid() on the instance being created
         */
        static::creating(
            function ($model) {
                if (!$model->getAttribute('code')) {
                    $model->setAttribute('code', static::generateCode());
                }
            }
        );
    }
}
