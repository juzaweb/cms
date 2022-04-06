<?php

namespace Juzaweb\Backend\Http\Controllers\Installer;

use Illuminate\Routing\Controller;
use Juzaweb\Events\InstallerFinished;
use Juzaweb\Support\Manager\FinalInstallManager;
use Juzaweb\Support\Manager\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param InstalledFileManager $fileManager
     * @param FinalInstallManager $finalInstall
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function finish(
        InstalledFileManager $fileManager,
        FinalInstallManager $finalInstall
    ) {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();

        event(new InstallerFinished());

        return view('installer::finished', compact(
            'finalMessages',
            'finalStatusMessage'
        ));
    }
}
