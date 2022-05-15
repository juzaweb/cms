<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Policies;

use Juzaweb\CMS\Abstracts\ResourcePolicy;

class EmailTemplatePolicy extends ResourcePolicy
{
    protected string $resourceType = 'email_templates';
}
