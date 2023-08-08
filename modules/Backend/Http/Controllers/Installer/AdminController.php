<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Installer;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('cms::installer.admin');
    }

    public function save(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:150',
                'email' => 'required|email|max:150',
                'password' => 'required|max:32|min:8|confirmed',
                'password_confirmation' => 'required|max:32|min:8',
            ],
            [],
            [
                'name' => trans('cms::app.name'),
                'email' => trans('cms::app.email'),
                'password' => trans('cms::app.password'),
                'password_confirmation' => trans('cms::app.confirm_password'),
            ]
        );

        if ($validator->fails()) {
            return redirect()
                ->route('installer.admin')
                ->withInput()
                ->withErrors($validator->errors());
        }

        DB::beginTransaction();
        try {
            $model = new User();
            $model->fill($request->all());
            $model->password = Hash::make($request->post('password'));
            $model->is_admin = 1;
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()
            ->to('install/final')
            ->with(
                [
                    'message' => trans('cms::installer.final.finished')
                ]
            );
    }
}
