<?php

namespace Juzaweb\Backend\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Models\User;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    
    protected function authUserAdmin()
    {
        $this->authUserId($this->getUserAdmin()->id);
    }
    
    protected function authUserId($userId)
    {
        Auth::loginUsingId($userId);
    }
    
    protected function getUserAdmin()
    {
        return User::where('is_admin', '=', 1)
            ->first();
    }
}
