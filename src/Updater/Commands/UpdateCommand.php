<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/15/2021
 * Time: 6:55 PM
 */

namespace Mymo\Updater\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mymo\Updater\UpdaterManager;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Finder\Finder;

class UpdateCommand extends Command
{
    protected $signature = 'mymo:update';

    protected $updater;

    public function __construct(UpdaterManager $updater)
    {
        parent::__construct();
        $this->updater = $updater;
    }

    public function handle()
    {
        dd(collect((new Finder())->in(base_path())
            ->exclude(config('updater.exclude_folders'))
            ->ignoreDotFiles(false)
            ->files()));

        if (!$this->updater->source()->isNewVersionAvailable()) {
            $this->info(trans('mymo_core::app.no_new_version_available'));
            exit;
        }

        Artisan::call('down');
        DB::beginTransaction();
        try {
            $versionAvailable = $this->updater->source()->getVersionAvailable();
            $release = $this->updater->source()->fetch($versionAvailable);
            $this->updater->source()->update($release);
            Artisan::call('migrate', ['--force'=> true]);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        Artisan::call('up');

        return $this->success([
            'message' => trans('mymo_core::app.updated_successfully'),
        ]);
    }
}