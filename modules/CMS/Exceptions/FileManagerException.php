<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Exceptions;

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
