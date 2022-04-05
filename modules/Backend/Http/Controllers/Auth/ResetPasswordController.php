<?php

namespace Juzaweb\Backend\Http\Controllers\Auth;

use Juzaweb\Http\Controllers\Controller;
use Juzaweb\Traits\Auth\AuthResetPassword;

class ResetPasswordController extends Controller
{
    use AuthResetPassword;
}
