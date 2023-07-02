<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\Backend\Repositories\UserRepository;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Frontend\Http\Requests\ChangePasswordRequest;
use Juzaweb\Frontend\Http\Requests\UpdateProfileRequest;

class ProfileController extends FrontendController
{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function index($slug = null)
    {
        $pages = HookAction::getProfilePages()->toArray();
        $page = $pages[$slug ?? 'index'];

        abort_unless($page, 404);

        $title = $page['title'];
        if ($callback = Arr::get($page, 'callback')) {
            return app()->call("{$callback[0]}@{$callback[1]}", ['page' => $page]);
        }

        return $this->view(
            'theme::profile.index',
            compact(
                'title',
                'slug',
                'pages'
            )
        );
    }

    public function update(UpdateProfileRequest $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        DB::transaction(
            function () use ($user, $request) {
                $update = $request->only(['name']);

                if ($password = $request->input('password')) {
                    $update['password'] = Hash::make($password);
                }

                $this->userRepository->update($update, $user->id);

                do_action('theme.profile.update', $user, $request->all());
            }
        );

        return $this->success(
            [
                'message' => trans('cms::message.update_successfully'),
            ]
        );
    }

    public function changePassword(Request $request)
    {
        $title = trans('cms::app.change_password');
        $user = UserResource::make($request->user())->toArray($request);

        return $this->view(
            'theme::profile.change_password',
            compact(
                'title',
                'user'
            )
        );
    }

    public function notification()
    {
        global $jw_user;

        $title = trans('cms::app.profile');

        $user = $jw_user;

        $notifications = $user->notifications->toArray();

        return $this->view(
            'theme::profile.notification.index',
            compact(
                'title',
                'notifications',
                'user'
            )
        );
    }

    public function doChangePassword(ChangePasswordRequest $request): JsonResponse|RedirectResponse
    {
        $currentPassword = $request->post('current_password');
        $password = $request->post('password');
        $user = $request->user();

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => trans('cms::app.current_password_incorrect'),
                ]
            );
        }

        DB::transaction(fn() => $user->update(['password' => Hash::make($password)]));

        return $this->success(
            [
                'message' => trans('cms::app.change_password_successfully'),
            ]
        );
    }
}
