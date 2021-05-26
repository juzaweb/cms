<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Mymo\Core\Http\Controllers\BackendController;
use Mymo\Core\Models\Movie\Movies;
use Mymo\Core\Models\Movie\MovieViews;
use Mymo\Core\Models\Pages;
use Mymo\Core\Models\User;
use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    public function index()
    {
        /*$count_movie = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 0)
            ->count('id');
        $count_tvserie = Movies::where('status', '=', 1)
            ->where('tv_series', '=', 1)
            ->count('id');*/
        $count_user = User::where('status', '=', 1)
            ->count('id');
        $count_page = Pages::where('status', '=', 1)
            ->count('id');
        
        return view('backend.dashboard', [
            //'count_movie' => $count_movie,
            //'count_tvserie' => $count_tvserie,
            'count_user' => $count_user,
            'count_page' => $count_page,
        ]);
    }
    
    public function getDataNotification(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $query = \Auth::user()->notifications();
        
        $query->orderBy('created_at', 'DESC');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
    
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('Y-m-d');
            $row->subject = $row->data['subject'];
            $row->url = route('account.notification.detail', [$row->id]);
        }
    
        return response()->json([
            'total' => count($rows),
            'rows' => $rows
        ]);
    }
    
    public function getDataUser(Request $request)
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
    
        $query = User::query();
        $query->where('status', '=', 1);
        $query->where('is_admin', '=', 0);
        
        $query->orderBy('created_at', 'DESC');
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get([
            'id',
            'name',
            'email',
            'created_at'
        ]);
    
        foreach ($rows as $row) {
            $row->created = $row->created_at->format('Y-m-d');
        }
    
        return response()->json([
            'total' => count($rows),
            'rows' => $rows
        ]);
    }
    
    public function viewsChart()
    {
        $max_day = date('t');
        $result = [];
        $result[] = [trans('app.day'), trans('app.views')];
        for ($i=1;$i<=$max_day;$i++) {
            $day = $i < 10 ? '0'. $i : $i;
            $result[] = [(string) $day, (int) $this->countViewByDay(date('Y-m-' . $day))];
        }
        
        return response()->json($result);
    }
    
    protected function countViewByDay($day)
    {
        return MovieViews::where('day', '=', $day)
            ->sum('views');
    }
}
