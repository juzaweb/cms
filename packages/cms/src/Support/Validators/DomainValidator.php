<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Validators;


class DomainValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        return filter_var($value, FILTER_VALIDATE_DOMAIN);
    }
}
