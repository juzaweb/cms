<?php

namespace Mymo\Installer\Controllers;

use Illuminate\Routing\Controller;
use Mymo\Installer\Events\LaravelInstallerFinished;
use Mymo\Installer\Helpers\EnvironmentManager;
use Mymo\Installer\Helpers\FinalInstallManager;
use Mymo\Installer\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Mymo\Installer\Helpers\InstalledFileManager $fileManager
     * @param \Mymo\Installer\Helpers\FinalInstallManager $finalInstall
     * @param \Mymo\Installer\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish (
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall,
        EnvironmentManager $environment
    )
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();

        event(new LaravelInstallerFinished);

        return view('installer::finished', compact(
            'finalMessages',
            'finalStatusMessage'
        ));
    }
}
