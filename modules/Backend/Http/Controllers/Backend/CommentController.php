<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Str;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Http\Datatables\CommentDatatable;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\CMS\Traits\ResourceController;

class CommentController extends BackendController
{
    use ResourceController {
        ResourceController::getDataForIndex as DataForIndex;
    }

    protected $viewPrefix = 'cms::backend.comment';

    protected function validator(array $attributes, ...$params)
    {
        $statuses = array_keys(Comment::allStatuses());

        return [
            'email' => 'required|email',
            'name' => 'nullable',
            'website' => 'nullable',
            'content' => 'required',
            'status' => 'required|in:' . implode(',', $statuses),
        ];
    }

    protected function getModel(...$params)
    {
        return Comment::class;
    }

    protected function getTitle(...$params)
    {
        return trans('cms::app.comments');
    }

    protected function getDataTable(...$params)
    {
        $dataTable = new CommentDatatable();
        $dataTable->mountData($this->getPostType());
        return $dataTable;
    }

    protected function getDataForIndex(...$params)
    {
        $type = $params[0];
        $postType = $this->getPostType();

        $data = $this->DataForIndex($type);
        $data['postType'] = $postType;
        return $data;
    }

    protected function getPostType()
    {
        return Str::plural(request()->segment(3));
    }
}
