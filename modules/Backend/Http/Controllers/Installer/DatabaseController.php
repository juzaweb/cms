<?php

namespace Juzaweb\Backend\Http\Controllers\Installer;

use Illuminate\Http\RedirectResponse;
use Juzaweb\CMS\Http\Controllers\Controller;
use Juzaweb\CMS\Support\Manager\DatabaseManager;

class DatabaseController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    /**
     * @param DatabaseManager $databaseManager
     */
    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Migrate and seed the database.
     *
     * @return RedirectResponse
     * @throws \Exception|\Throwable
     */
    public function database(): RedirectResponse
    {
        $response = $this->databaseManager->run();

        return redirect()
            ->route('installer.admin')
            ->with(['message' => $response]);
    }
}
