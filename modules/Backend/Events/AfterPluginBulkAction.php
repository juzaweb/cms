<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterPluginBulkAction
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public string $action;

    public array $plugins;

    public function __construct(string $action, array $plugins)
    {
        $this->action = $action;
        $this->plugins = $plugins;
    }
}
