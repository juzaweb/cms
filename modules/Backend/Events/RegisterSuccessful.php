<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Events;

use Juzaweb\CMS\Models\User;

class RegisterSuccessful
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
