<?php

namespace Mymo\Installer\Helpers;

use Exception;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mymo\Email\Models\EmailTemplate;
use Symfony\Component\Console\Output\BufferedOutput;
use Mymo\Core\Models\Config as DbConfig;

class DatabaseManager
{
    /**
     * Migrate and seed the database.
     *
     * @return array
     * @throws Exception
     */
    public function run()
    {
        $outputLog = new BufferedOutput();
        $this->sqlite($outputLog);

        DB::beginTransaction();
        try {
            $migrate = $this->migrate($outputLog);
            $this->makeConfig();
            $this->makeEmailTemplate();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e);
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $migrate;
    }

    /**
     * Run the migration and call the seeder.
     *
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function migrate(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('migrate', ['--force'=> true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(trans('installer::installer_messages.final.database_finished'), 'success', $outputLog);
    }

    /**
     * Seed the database.
     *
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function seed(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('db:seed', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return $this->response($e->getMessage(), 'error', $outputLog);
        }

        return $this->response(trans('installer::installer_messages.final.finished'), 'success', $outputLog);
    }

    /**
     * Return a formatted error messages.
     *
     * @param string $message
     * @param string $status
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     * @return array
     */
    private function response($message, $status, BufferedOutput $outputLog)
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
     * @param \Symfony\Component\Console\Output\BufferedOutput $outputLog
     */
    private function sqlite(BufferedOutput $outputLog)
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

    private function makeConfig()
    {
        DbConfig::setConfig('title', 'MyMo - The Best Laravel CMS');
        DbConfig::setConfig('description', 'Mymo is a Content Management System (CMS) and web platform whose sole purpose is to make your development workflow simple again.');
        DbConfig::setConfig('author_name', 'MyMo Team');
        DbConfig::setConfig('user_registration', 1);
        DbConfig::setConfig('user_verification', 0);
    }

    private function makeEmailTemplate()
    {
        EmailTemplate::create([
            'code' => 'verification',
            'subject' => 'Verify your account',
            'body' => '<p>Hello {name},</p>
<p>Thank you for register. Please click the link below to Verify your account</p>
<p><a href="{url}" target="_blank">Verify account</a></p>',
            'params' => [
                'name' => 'Your Name',
            ],
        ]);

        EmailTemplate::create([
            'code' => 'forgot_password',
            'subject' => 'Password Reset for you account',
            'body' => '<p>Someone has requested a password reset for the following account:</p>
<p>Email: {email}</p>
<p>If this was a mistake, just ignore this email and nothing will happen.To reset your password, visit the following address:</p>
<p><a href="{url}" target="_blank">{url}</a></p>',
            'params' => [
                'name' => 'Your Name',
            ],
        ]);
    }
}
