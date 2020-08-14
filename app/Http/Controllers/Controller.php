<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function callAction($method, $parameters)
    {
        if (!file_exists(base_path('installed'))) {
            if (!in_array(\Route::currentRouteName(), ['install', 'install.submit', 'install.submit.step'])) {
                return redirect()->route('install');
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
}
