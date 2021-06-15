<?php

namespace Mymo\Core\Http\Controllers\Backend;

use Mymo\Core\Http\Controllers\BackendController;
use Mymo\PostType\Models\Page;
use Mymo\Core\Models\User;
use Illuminate\Http\Request;

class DashboardController extends BackendController
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        return view('mymo_core::backend.dashboard', [
            'title' => trans('mymo_core::app.dashboard'),
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
        $result[] = [trans('mymo_core::app.day'), trans('mymo_core::app.views')];
        for ($i=1;$i<=$max_day;$i++) {
            $day = $i < 10 ? '0'. $i : $i;
            $result[] = [(string) $day, (int) $this->countViewByDay(date('Y-m-' . $day))];
        }
        
        return response()->json($result);
    }
}
