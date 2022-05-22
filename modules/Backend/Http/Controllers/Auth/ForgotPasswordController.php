<?php

namespace Juzaweb\Backend\Http\Controllers\Auth;

use Juzaweb\CMS\Http\Controllers\Controller;
use Juzaweb\CMS\Traits\Auth\AuthForgotPassword;

class ForgotPasswordController extends Controller
{
    use AuthForgotPassword;
}
