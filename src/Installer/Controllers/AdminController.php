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
 * Date: 6/13/2021
 * Time: 12:50 PM
 */

namespace Mymo\Installer\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Mymo\Core\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('installer::admin');
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:150',
            'email' => 'required|email|max:150',
            'password' => 'required|max:32|min:8|confirmed',
            'password_confirmation' => 'required|max:32|min:8',
        ], [], [
            'name' => trans('mymo_core::app.name'),
            'email' => trans('mymo_core::app.email'),
            'password' => trans('mymo_core::app.password'),
            'password_confirmation' => trans('mymo_core::app.confirm_password')
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('installer::admin')
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

        return redirect()->route('installer::final')
            ->with(['message' => trans('installer::installer_messages.final.finished')]);
    }
}