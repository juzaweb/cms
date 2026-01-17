<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\Core\Http\DataTables\NotificationsDataTable;
use Juzaweb\Modules\VideoSharing\Models\Video;
use Juzaweb\Themes\Itube\Http\DataTables\MyVideosDataTable;
use Juzaweb\Themes\Itube\Http\Requests\ProfileUpdateRequest;

class ProfileController extends ThemeController
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('itube::profile.index', compact('user'));
    }

    public function notification(Request $request, NotificationsDataTable $dataTable)
    {
        $user = $request->user();

        return $dataTable->render(
            'itube::profile.notification',
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
            __('itube::translation.profile_updated_successfully'),
        );
    }

    public function myVideos(Request $request, MyVideosDataTable $dataTable)
    {
        $user = $request->user();

        return $dataTable->render(
            'itube::profile.my-videos',
            compact('user')
        );
    }

    public function editVideo(Request $request, string $id)
    {
        $user = $request->user();
        $video = Video::with(['channel', 'media', 'playlists'])
            ->where('id', $id)
            ->where('created_by', $user->id)
            ->firstOrFail();

        return view('itube::profile.edit-video', compact('user', 'video'));
    }

    public function updateVideo(Request $request, string $id)
    {
        $user = $request->user();
        $video = Video::where('id', $id)
            ->where('created_by', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'mode' => 'required|in:public,private,unlisted',
        ]);

        DB::transaction(function () use ($video, $validated) {
            $video->update([
                'mode' => $validated['mode'],
                config('translatable.fallback_locale') => [
                    'title' => $validated['title'],
                    'description' => $validated['description'] ?? '',
                ],
            ]);
        });

        return $this->success([
            'message' => __('itube::translation.video_updated_successfully'),
            'redirect' => url('profile/my-videos'),
        ]);
    }

    public function deleteVideo(Request $request, string $id)
    {
        $user = $request->user();
        $video = Video::where('id', $id)
            ->where('created_by', $user->id)
            ->firstOrFail();

        $video->delete();

        return $this->success([
            'message' => __('itube::translation.video_deleted_successfully'),
        ]);
    }

    public function bulkAction(Request $request)
    {
        $user = $request->user();
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return $this->error(__('itube::translation.no_items_selected'));
        }

        switch ($action) {
            case 'delete':
                Video::where('created_by', $user->id)
                    ->whereIn('id', $ids)
                    ->delete();
                return $this->success([
                    'message' => __('itube::translation.videos_deleted_successfully'),
                ]);
            default:
                return $this->error(__('itube::translation.invalid_action'));
        }
    }
}
