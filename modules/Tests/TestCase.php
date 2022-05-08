<?php

namespace Juzaweb\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Models\User;

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

    protected function getUserAdmin(): User|null
    {
        return User::where('is_admin', '=', 1)
            ->first();
    }

    protected function printText($text)
    {
        echo "{$text} \n";
    }
}
