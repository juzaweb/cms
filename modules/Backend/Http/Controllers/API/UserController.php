<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
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
