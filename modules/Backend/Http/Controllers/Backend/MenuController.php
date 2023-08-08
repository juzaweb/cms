<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Models\Menu;
use Juzaweb\Backend\Models\MenuItem;
use Juzaweb\CMS\Facades\GlobalData;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;

class MenuController extends BackendController
{
    public function index($id = null)
    {
        do_action('backend.menu.index', $id);

        $title = trans('cms::app.menu');
        $navMenus = GlobalData::get('nav_menus');
        $location = get_theme_config('nav_location');

        add_action('juzaweb.add_menu_items', [$this, 'addMenuBoxs']);

        if (empty($id)) {
            $menu = Menu::first();
        } else {
            $menu = Menu::where('id', '=', $id)->first();
        }

        return view(
            'cms::backend.menu.index',
            compact(
                'title',
                'menu',
                'navMenus',
                'location'
            )
        );
    }

    public function addItem(Request $request)
    {
        $request->validate(
            [
                'key' => 'required',
            ],
            [],
            [
                'key' => trans('cms::app.key'),
            ]
        );

        $menuRegister = HookAction::getMenuBox($request->post('key'));

        if (empty($menuRegister)) {
            return $this->error(
                [
                    'message' => 'Cannot find menu box',
                ]
            );
        }

        $menuBox = $menuRegister->get('menu_box');

        $result = [];
        $data = $menuBox->mapData($request->all());

        foreach ($data as $item) {
            $model = new MenuItem();
            $model->fill(
                array_merge(
                    $item,
                    [
                        'box_key' => $request->post('key'),
                    ]
                )
            );

            $result[] = view(
                'cms::backend.items.menu_item',
                [
                    'item' => $model,
                ]
            )->render();
        }

        return $this->success(
            [
                'items' => $result,
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:250',
            ],
            [],
            [
                'name' => trans('cms::app.name'),
            ]
        );

        $model = Menu::create($request->all());

        return $this->success(
            [
                'message' => trans('cms::app.saved_successfully'),
                'redirect' => route('admin.menu.id', [$model->id]),
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:150',
                'content' => 'required',
            ],
            [],
            [
                'name' => trans('cms::app.name'),
                'content' => trans('cms::app.menu'),
            ]
        );

        $items = json_decode($request->post('content'), true);

        DB::beginTransaction();

        try {
            $model = Menu::findOrFail($id);
            $model->update($request->all());
            $model->syncItems($items);

            if ($location = $request->post('location', [])) {
                $locationConfig = get_theme_config('nav_location');
                foreach ($location as $item) {
                    $locationConfig[$item] = $model->id;
                }

                set_theme_config('nav_location', $locationConfig);
            } else {
                $location = collect(get_theme_config('nav_location'))
                    ->filter(
                        function ($i) use ($model) {
                            return $i != $model->id;
                        }
                    )->toArray();

                set_theme_config('nav_location', $location);
            }

            do_action('admin.saved_menu', $model, $items);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $this->success(
            [
                'message' => trans('cms::app.saved_successfully'),
                'redirect' => route('admin.menu.id', [$model->id]),
            ]
        );
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return $this->success(
            [
                'message' => trans('cms::app.deleted_successfully'),
            ]
        );
    }

    public function addMenuBoxs()
    {
        $menuBoxs = GlobalData::get('menu_boxs');

        foreach ($menuBoxs as $key => $item) {
            echo e(
                view(
                    'cms::backend.items.menu_box',
                    [
                        'label' => $item['title'],
                        'key' => $key,
                        'slot' => $item['menu_box']->addView()->render(),
                    ]
                )
            );
        }
    }
}
