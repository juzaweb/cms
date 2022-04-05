<?php

namespace Juzaweb\CMS\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/install',
        '/install/step/1',
        '/install/step/2',
        '/install/step/3',
        '/install/step/4',
    ];
}
