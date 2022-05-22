<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\API;

use Illuminate\Http\Request;
use Juzaweb\CMS\Http\Controllers\ApiController;
use Juzaweb\Backend\Http\Resources\UserResource;

class UserController extends ApiController
{
    public function index(Request $request)
    {
        //
    }

    public function show(Request $request)
    {
        return new UserResource($request->user());
    }
}
