<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
