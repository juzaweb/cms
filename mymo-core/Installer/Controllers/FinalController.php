<?php

namespace Tadcms\Installer\Controllers;

use Illuminate\Routing\Controller;
use Tadcms\Installer\Events\LaravelInstallerFinished;
use Tadcms\Installer\Helpers\EnvironmentManager;
use Tadcms\Installer\Helpers\FinalInstallManager;
use Tadcms\Installer\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param \Tadcms\Installer\Helpers\InstalledFileManager $fileManager
     * @param \Tadcms\Installer\Helpers\FinalInstallManager $finalInstall
     * @param \Tadcms\Installer\Helpers\EnvironmentManager $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('installer::finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
