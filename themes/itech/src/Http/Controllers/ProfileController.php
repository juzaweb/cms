<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itech\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\Core\Http\DataTables\NotificationsDataTable;
use Juzaweb\Modules\Core\Http\Requests\ProfileUpdateRequest;

class ProfileController extends ThemeController
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('itech::profile.index', compact('user'));
    }

    public function notification(Request $request, NotificationsDataTable $dataTable)
    {
        $user = $request->user();

        return $dataTable->render(
            'itech::profile.notification',
            compact('user')
        );
    }

    public function update(ProfileUpdateRequest $request)
    {
        DB::transaction(
            function () use ($request) {
                $user = $request->user();
                $user->name = $request->input('name');
                if ($request->filled('password')) {
                    $user->password = bcrypt($request->input('password'));
                }
                $user->save();

                return $user;
            }
        );

        return $this->success(
            __('itech::translation.profile_updated_successfully'),
        );
    }
}
