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
 * Date: 5/25/2021
 * Time: 10:10 PM
 */

namespace Mymo\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BackendController extends Controller
{
    public function callAction($method, $parameters)
    {
        if (!file_exists(storage_path('app/installed'))) {
            if (!in_array(\Route::currentRouteName(), ['install', 'install.submit', 'install.submit.step'])) {
                return redirect()->route('install');
            }
        }

        if (config('mymo_core::app.demo') == 'true' && \Auth::id() != 1) {
            if (\request()->isMethod('post')) {
                if (\request()->is('admin-cp/*')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You cannot change the demo version',
                    ]);
                }

                if (\request()->is('account/change-password')) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You cannot change the demo version',
                    ]);
                }
            }
        }

        return parent::callAction($method, $parameters);
    }

    protected function validateRequest($rules, Request $request, $attributeNames = null) {
        $validator = Validator::make($request->all(), $rules);

        if ($attributeNames) {
            $validator->setAttributeNames($attributeNames);
        }

        if ($validator->fails()) {
            json_message($validator->errors()->all()[0], 'error');
        }
    }

    protected function addBreadcrumb(array $item, $name = 'admin')
    {
        add_filters($name . '_breadcrumb', function ($items) use ($item) {
            $items[] = $item;
            return $items;
        });
    }
}