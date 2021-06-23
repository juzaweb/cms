<?php

namespace Mymo\Backend\Http\Controllers\Backend\Setting;

use Mymo\Core\Models\Config;
use Illuminate\Http\Request;
use Mymo\Backend\Http\Controllers\Controller;

class CommentSettingController extends Controller
{
    public function index() {
        return view('mymo::backend.setting.comment.index', [
            'title' => trans('mymo::app.comment_setting')
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'comment_able' => 'required|in:0,1',
            'comment_type' => 'required_if:comment_able,!=,0|string|max:300',
            'comments_per_page' => 'required|string|max:300',
            'comments_approval' => 'required|string|max:300',
        ], $request, [
            'comment_able' => trans('mymo::app.comment_able'),
            'comment_type' => trans('mymo::app.comment_type'),
            'comments_per_page' => trans('mymo::app.comments_per_page'),
            'comments_approval' => trans('mymo::app.comments_approval'),
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
            'message' => trans('mymo::app.saved_successfully'),
            'redirect' => route('admin.setting.comment'),
        ]);
    }
}
