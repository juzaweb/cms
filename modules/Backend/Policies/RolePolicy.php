<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Policies;

use Juzaweb\Backend\Abstracts\ResourcePolicy;

class RolePolicy extends ResourcePolicy
{
    protected $resourceType = 'roles';
}
