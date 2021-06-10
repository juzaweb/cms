<?php

namespace Mymo\Core\Http\Controllers\Backend\Setting;

use Mymo\Core\Models\Config;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\Controller;

class CommentSettingController extends Controller
{
    public function index() {
        return view('mymo_core::backend.setting.comment.index', [
            'title' => trans('mymo_core::app.comment_setting')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'comment_able' => 'required|in:0,1',
            'comment_type' => 'required_if:comment_able,!=,0|string|max:300',
            'comments_per_page' => 'required|string|max:300',
            'comments_approval' => 'required|string|max:300',
        ], $request, [
            'comment_able' => trans('mymo_core::app.comment_able'),
            'comment_type' => trans('mymo_core::app.comment_type'),
            'comments_per_page' => trans('mymo_core::app.comments_per_page'),
            'comments_approval' => trans('mymo_core::app.comments_approval'),
        ]);
    
        $configs = $request->only([
            'comment_able',
            'comment_type',
            'comments_per_page',
            'comments_approval',
        ]);
        
        foreach ($configs as $key => $config) {
            Config::setConfig($key, $config);
        }
    
        return response()->json([
            'status' => 'success',
            'message' => trans('mymo_core::app.saved_successfully'),
            'redirect' => route('admin.setting.comment'),
        ]);
    }
}
