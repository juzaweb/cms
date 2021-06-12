<?php

namespace Plugins\Movie\Http\Controllers\Backend;

use Illuminate\Support\Facades\Validator;
use Mymo\Core\Traits\ResourceController;
use Plugins\Movie\Models\Slider;
use Illuminate\Http\Request;
use Mymo\Core\Http\Controllers\BackendController;

class SliderController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'movie::slider';

    protected function validator(array $attributes)
    {
        $validator = Validator::make($attributes, [
            'name' => 'required|string|max:250',
        ]);

        return $validator;
    }

    public function getDataTable(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Slider::query();
        
        if ($search) {
            $query->where('name', 'like', '%'. $search .'%');
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->edit_url = route('admin.sliders.edit', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function parseDataForSave(array $attributes)
    {
        $titles = $attributes['title'] ?? [];
        $links = $attributes['link'] ?? [];
        $images = $attributes['image'];
        $descriptions = $attributes['description'] ?? [];
        $newTab = $attributes['new_tab'] ?? [];

        $content = [];
        foreach ($titles as $key => $title) {
            $content[] = [
                'title' => $title,
                'link' => $links[$key] ?? null,
                'image' => $images[$key] ?? null,
                'description' => $descriptions[$key] ?? null,
                'new_tab' => $newTab[$key] ?? 0,
            ];
        }
    
        $attributes['content'] = $content;
        return $attributes;
    }

    protected function getModel()
    {
        return Slider::class;
    }

    protected function getTitle()
    {
        return trans('movie::app.sliders');
    }
}
