<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Policies;

use Juzaweb\Backend\Abstracts\ResourcePolicy;

class EmailTemplatePolicy extends ResourcePolicy
{
    protected $resourceType = 'email_templates';
}
