<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailHook
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $hook;
    public $args = [];

    public function __construct($hook, $args = [])
    {
        $this->hook = $hook;
        $this->args = $args;
    }
}
