<?php

namespace Mymo\Installer\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Mymo\Installer\Helpers\DatabaseManager;

class DatabaseController extends Controller
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

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
     * @return \Illuminate\View\View
     * @throws \Exception
     */
    public function database()
    {
        $response = $this->databaseManager->run();

        return redirect()->route('Installer::final')
                         ->with(['message' => $response]);
    }
}
