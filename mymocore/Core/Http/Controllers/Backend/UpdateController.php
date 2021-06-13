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
 * Date: 6/13/2021
 * Time: 11:09 AM
 */

namespace Mymo\Core\Http\Controllers\Backend;

use Illuminate\Support\Facades\Artisan;
use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Updater\UpdaterManager;

class UpdateController extends BackendController
{
    protected $updater;

    public function __construct(UpdaterManager $updater)
    {
        $this->updater = $updater;
    }

    public function index()
    {
        return view('mymo_core::backend.update', [
            'title' => trans('mymo_core::app.updates'),
            'updater' => $this->updater
        ]);
    }

    public function update()
    {
        if (!$this->updater->source()->isNewVersionAvailable()) {
            return $this->error([
                'message' => trans('mymo_core::app.no_new_version_available'),
            ]);
        }

        $versionAvailable = $this->updater->source()->getVersionAvailable();
        $release = $this->updater->source()->fetch($versionAvailable);
        $this->updater->source()->update($release);
        Artisan::call('migrate', ['--force'=> true]);

        return $this->success([
            'message' => trans('mymo_core::app.updated_successfully'),
        ]);
    }
}