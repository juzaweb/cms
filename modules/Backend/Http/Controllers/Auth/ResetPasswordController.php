<?php

namespace Juzaweb\Backend\Http\Controllers\Auth;

use Juzaweb\CMS\Http\Controllers\Controller;
use Juzaweb\CMS\Traits\Auth\AuthResetPassword;

class ResetPasswordController extends Controller
{
    use AuthResetPassword;
}
