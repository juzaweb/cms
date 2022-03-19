<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Juzaweb\Abstracts\Action;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Backend\Models\MediaFile;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\PostView;
use Juzaweb\Models\User;

class DashboardController extends BackendController
{
    public function index()
    {
        do_action(Action::BACKEND_DASHBOARD_ACTION);

        $title = trans('cms::app.dashboard');
        $users = User::count();
        $posts = Post::where('type', '=', 'posts')
            ->count();
        $pages = Post::where('type', '=', 'pages')
            ->count();
        $storage = format_size_units(MediaFile::sum('size'));

        return view('cms::backend.dashboard', compact(
            'title',
            'users',
            'posts',
            'pages',
            'storage'
        ));
    }

    public function getDataUser(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);

        $query = User::query();
        $query->where('status', '=', User::STATUS_ACTIVE);
        $query->where('is_admin', '=', 0);

        $query->orderBy('created_at', 'DESC');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get([
            'id',
            'name',
            'email',
            'created_at',
        ]);

        foreach ($rows as $row) {
            $row->created = jw_date_format($row->created_at);
        }

        return response()->json([
            'total' => count($rows),
            'rows' => $rows,
        ]);
    }

    public function getDataTopViews(Request $request)
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

                $rows = $query->get([
                    'id',
                    'title',
                    'views',
                    'created_at',
                ]);

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

    public function viewsChart()
    {
        $result = Cache::store('file')->remember(
            cache_prefix('views_chart'),
            3600,
            function () {
                $result = [];
                $result[] = [
                    trans('cms::app.day'),
                    trans('cms::app.views')
                ];

                $today = Carbon::today();
                $minDay = $today->subDays(7);

                for ($i = 1; $i <= 7; $i++) {
                    $day = $minDay->addDay();
                    $result[] = [
                        (string) $day->format('Y-m-d'),
                        (int) $this->countViewByDay($day->format('Y-m-d'))
                    ];
                }

                return $result;
            }
        );

        return response()->json($result);
    }

    protected function countViewByDay($day)
    {
        return PostView::where('day', '=', $day)
            ->sum('views');
    }
}
