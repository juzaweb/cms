<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Juzaweb\Network\Contracts\SiteManagerContract;

class MakeSiteCommand extends Command
{
    protected $signature = 'network:make-site {subdomain}';

    public function handle(): int
    {
        $subdomain = $this->argument('subdomain');

        //DB::beginTransaction();
        try {
            app(SiteManagerContract::class)->create($subdomain);

            //DB::commit();
        } catch (\Exception | \Error $e) {
            //DB::rollBack();
            throw $e;
        }

        $this->info("Site {$subdomain} created successfully.");

        return self::SUCCESS;
    }
}
