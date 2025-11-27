<?php

namespace Mhstore\LaravelInstaller\Controllers;

use Illuminate\Routing\Controller;
use Mhstore\LaravelInstaller\Events\LaravelInstallerFinished;
use Mhstore\LaravelInstaller\Helpers\EnvironmentManager;
use Mhstore\LaravelInstaller\Helpers\FinalInstallManager;
use Mhstore\LaravelInstaller\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  \Mhstore\LaravelInstaller\Helpers\InstalledFileManager  $fileManager
     * @param  \Mhstore\LaravelInstaller\Helpers\FinalInstallManager  $finalInstall
     * @param  \Mhstore\LaravelInstaller\Helpers\EnvironmentManager  $environment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall, EnvironmentManager $environment)
    {
        $finalMessages = $finalInstall->runFinal();
        $finalStatusMessage = $fileManager->update();
        $finalEnvFile = $environment->getEnvContent();

        event(new LaravelInstallerFinished);

        return view('vendor.installer.finished', compact('finalMessages', 'finalStatusMessage', 'finalEnvFile'));
    }
}
