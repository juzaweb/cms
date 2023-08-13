<?php

namespace Juzaweb\CMS\Support\Manager;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;
use Throwable;

class FinalInstallManager
{
    /**
     * Run final commands.
     *
     * @return array
     * @throws Throwable
     */
    public function runFinal(): array
    {
        $outputLog = new BufferedOutput();
        try {
            $this->generateKey($outputLog);
            $this->clearOptimize($outputLog);
            $this->publishStorage($outputLog);
            $this->publishVendorAssets($outputLog);
        } catch (Throwable $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(trans('cms::app.successfully'), 'success', $outputLog);
    }

    private function generateKey(BufferedOutput $outputLog): void
    {
        if (config('installer.final.key')) {
            Artisan::call('key:generate', ['--force' => true], $outputLog);
        }
    }

    private function publishStorage(BufferedOutput $outputLog): void
    {
        Artisan::call('storage:link', [], $outputLog);
    }

    private function publishVendorAssets(BufferedOutput $outputLog): void
    {
        Artisan::call(
            'cms:publish',
            [
                'type' => 'assets',
            ],
            $outputLog
        );

        Artisan::call('storage:link', [], $outputLog);
    }

    private function clearOptimize(BufferedOutput $outputLog): void
    {
        Artisan::call('optimize:clear', [], $outputLog);
    }

    private function response($message, $status, BufferedOutput $outputLog): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }
}
