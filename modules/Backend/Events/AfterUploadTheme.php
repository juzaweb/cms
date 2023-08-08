<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterUploadTheme
{
    use Dispatchable;
    use SerializesModels;

    protected array $theme;

    public function __construct(array $theme)
    {
        $this->theme = $theme;
    }
}
