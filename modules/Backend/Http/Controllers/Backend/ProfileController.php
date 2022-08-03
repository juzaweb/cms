<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Juzaweb\Backend\Http\Requests\User\ProfileUpdateRequest;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ProfileController extends BackendController
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $title = trans('cms::app.profile');

        return view(
            'cms::backend.profile.index',
            compact('title')
        );
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->only(['name', 'avatar']));

        //
    }
}
