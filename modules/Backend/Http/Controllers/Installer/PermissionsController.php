<?php

namespace Juzaweb\Backend\Http\Controllers\Installer;

use Illuminate\Routing\Controller;
use Juzaweb\CMS\Support\PermissionsChecker;

class PermissionsController extends Controller
{
    /**
     * @var PermissionsChecker
     */
    protected $permissions;

    /**
     * @param PermissionsChecker $checker
     */
    public function __construct(PermissionsChecker $checker)
    {
        $this->permissions = $checker;
    }

    /**
     * Display the permissions check page.
     *
     * @return \Illuminate\View\View
     */
    public function permissions()
    {
        $permissions = $this->permissions->check([
            'storage/' => '775',
            'bootstrap/cache/' => '775',
            'resources/' => '775',
            'public/' => '775',
            'plugins/' => '775',
            'themes/' => '775',
            'vendor/' => '775',
        ]);

        return view(
            'cms::installer.permissions',
            compact('permissions')
        );
    }
}
