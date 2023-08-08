<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Traits;

use Illuminate\Support\Str;

trait UUIDPrimaryKey
{
    protected static function bootUUIDPrimaryKey(): void
    {
        /**
         * Listen for the creating event on the user model.
         * Sets the 'id' to a UUID using Str::uuid() on the instance being created
         */
        static::creating(
            function ($model) {
                if ($model->getKey() === null) {
                    $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
                }
            }
        );
    }

    // Tells the database not to auto-increment this field
    public function getIncrementing(): bool
    {
        return false;
    }

    // Helps the application specify the field type in the database
    public function getKeyType(): string
    {
        return 'string';
    }
}
