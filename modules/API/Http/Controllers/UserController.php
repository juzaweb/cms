<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\API\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Resources\UserResource;
use Juzaweb\CMS\Http\Controllers\ApiController;

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
