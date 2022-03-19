<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Exceptions;

class FileManagerException extends \Exception
{
    /**
     * @param array $errors
     */
    public function __construct($errors)
    {
        parent::__construct(implode("\n", $errors));
    }
}
