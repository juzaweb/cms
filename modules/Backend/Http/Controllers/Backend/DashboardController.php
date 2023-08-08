<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\PostView;
use Juzaweb\CMS\Models\User;

class DashboardController extends BackendController
{
    public function index(): View
    {
        do_action(Action::BACKEND_DASHBOARD_ACTION);

        $title = trans('cms::app.dashboard');
        $users = User::count();
        $posts = Post::where('type', '!=', 'pages')
            ->wherePublish()
            ->count();
        $pages = Post::where('type', '=', 'pages')
            ->wherePublish()
            ->count();
        $storage = format_size_units(MediaFile::sum('size'));
        $diskFree = Cache::store('file')->remember(
            cache_prefix('storage_free_disk'),
            3600,
            fn() => format_size_units(disk_free_space('/')),
        );

        return $this->view(
            'cms::backend.dashboard',
            compact(
                'title',
                'users',
                'posts',
                'pages',
                'storage',
                'diskFree'
            )
        );
    }

    public function getDataUser(Request $request): JsonResponse
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = User::query();
        $query->where('status', '=', User::STATUS_ACTIVE);
        $query->where('is_admin', '=', 0);

        $query->orderBy('created_at', 'DESC');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get(
            [
                'id',
                'name',
                'email',
                'created_at',
            ]
        );

        foreach ($rows as $row) {
            $row->created = jw_date_format($row->created_at);
        }

        return response()->json(
            [
                'total' => count($rows),
                'rows' => $rows,
            ]
        );
    }

    public function getDataTopViews(Request $request): JsonResponse
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $result = Cache::store('file')->remember(
            cache_prefix('data_top_views'),
            3600,
            function () use ($offset, $limit) {
                $query = Post::query();
                $query->wherePublish();

                $query->orderBy('views', 'DESC');
                $query->offset($offset);
                $query->limit($limit);

                $rows = $query->get(
                    [
                        'id',
                        'title',
                        'views',
                        'created_at',
                    ]
                );

                foreach ($rows as $row) {
                    $row->created = jw_date_format($row->created_at);
                    $row->views = number_format($row->views);
                }

                return [
                    'total' => count($rows),
                    'rows' => $rows,
                ];
            }
        );

        return response()->json($result);
    }

    public function viewsChart(): JsonResponse
    {
        $result = Cache::store('file')->remember(
            cache_prefix('views_chart'),
            3600,
            function () {
                $result = [];
                $today = Carbon::today();
                $minDay = $today->subDays(7);

                for ($i = 1; $i <= 7; $i++) {
                    $day = $minDay->addDay();
                    $result[] = [
                        $day->format('Y-m-d'),
                        $this->countViewByDay($day->format('Y-m-d')),
                        $this->countUserByDay($day->format('Y-m-d')),
                    ];
                }

                return $result;
            }
        );

        return response()->json($result);
    }

    public function removeMessage(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate(
            [
                'id' => 'required'
            ],
            [],
            [
                'id' => trans('Message ID')
            ]
        );

        remove_backend_message($request->input('id'));

        return $this->success(
            [
                'message' => trans('cms::app.successfully')
            ]
        );
    }

    protected function countViewByDay(string $day): int
    {
        return PostView::where('day', '=', $day)->sum('views');
    }

    protected function countUserByDay(string $day): int
    {
        return User::whereDate('created_at', '=', $day)->count('id');
    }
}
