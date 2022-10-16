<?php

namespace Juzaweb\CMS\Support\Manager;

use Exception;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Juzaweb\CMS\Facades\Config as DbConfig;
use Symfony\Component\Console\Output\BufferedOutput;

class DatabaseManager
{
    /**
     * Migrate and seed the database.
     *
     * @return array
     * @throws Exception
     * @throws \Throwable
     */
    public function run(): array
    {
        $outputLog = new BufferedOutput();
        $this->sqlite($outputLog);

        $migrate = $this->migrate($outputLog);
        if ($migrate['status'] == 'error') {
            return $this->response($migrate['message'], 'error', $outputLog);
        }

        DB::beginTransaction();
        try {
            $this->makeConfig();
            $this->makeEmailTemplate($outputLog);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $migrate;
    }

    /**
     * Run the migration and call the seeder.
     *
     * @param BufferedOutput $outputLog
     * @return array
     */
    private function migrate(BufferedOutput $outputLog): array
    {
        try {
            Artisan::call('migrate', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(trans('cms::installer.final.database_finished'), 'success', $outputLog);
    }

    /**
     * Return a formatted error messages.
     *
     * @param string $message
     * @param string $status
     * @param BufferedOutput $outputLog
     * @return array
     */
    private function response($message, $status, BufferedOutput $outputLog): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }

    /**
     * Check database type. If SQLite, then create the database file.
     *
     * @param BufferedOutput $outputLog
     */
    private function sqlite(BufferedOutput $outputLog): void
    {
        if (DB::connection() instanceof SQLiteConnection) {
            $database = DB::connection()->getDatabaseName();
            if (! file_exists($database)) {
                touch($database);
                DB::reconnect(Config::get('database.default'));
            }
            $outputLog->write('Using SqlLite database: '.$database, 1);
        }
    }

    private function makeConfig(): void
    {
        DbConfig::setConfig('title', 'JuzaCMS - Laravel CMS for Your Project');
        DbConfig::setConfig(
            'description',
            'Juzacms is a Content Management System (CMS)'
            . ' and web platform whose sole purpose is to make your development workflow simple again.'
        );
        DbConfig::setConfig('author_name', 'Juzaweb Team');
        DbConfig::setConfig('user_registration', 1);
        DbConfig::setConfig('user_verification', 0);
    }

    private function makeEmailTemplate(BufferedOutput $outputLog): array
    {
        try {
            Artisan::call('mail:generate-template', [], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(trans('cms::installer.final.database_finished'), 'success', $outputLog);
    }
}
