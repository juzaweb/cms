<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/31/2021
 * Time: 9:56 PM
 */

namespace Mymo\PostType\Datatables;

use Illuminate\Http\Request;
use Mymo\PostType\Models\Post;

class PostDatatable
{
    public function query(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $query = Post::query();

        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }

        if ($status) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function columns()
    {
        return [
            'thumbnail' => [
                'label' => trans('mymo_core::app.thumbnail'),
                'formatter' => [$this, 'thumbnailFormatter']
            ],
            'title' => [
                'label' => trans('mymo_core::app.title'),
                'formatter' => [$this, 'thumbnailFormatter']
            ],
            'created_at' => trans('mymo_core::app.created_at'),
            'status' => trans('mymo_core::app.status'),
        ];
    }

    public function thumbnailFormatter($value, $row, $index)
    {
        return '<img src="'. $row->thumb_url .'" class="w-100">';
    }

    public function nameFormatter($row)
    {

    }

    public function statusFormatter()
    {

    }
}