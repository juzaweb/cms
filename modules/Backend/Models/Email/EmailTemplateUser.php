<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Models\Email;

use Juzaweb\CMS\Models\Model;

/**
 * Juzaweb\Backend\Models\Email\EmailTemplateUser
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplateUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplateUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplateUser query()
 * @mixin \Eloquent
 */
class EmailTemplateUser extends Model
{
    protected $table = 'email_template_users';
    protected $fillable = ['user_id', 'email_template_id'];
}
