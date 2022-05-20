<?php

namespace Juzaweb\CMS\Support\Manager;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (! file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileClassic(Request $input)
    {
        $message = trans('cms::installer.environment.success');

        try {
            file_put_contents($this->envPath, $input->get('envConfig'));
        } catch (Exception $e) {
            $message = trans('cms::installer.environment.errors');
        }

        return $message;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('cms::installer.environment.success');
        $url = url('/');

        $envFileData =
        "APP_NAME=Juzaweb\n".
        "APP_ENV=production\n".
        "APP_KEY=base64:".base64_encode(Str::random(32))."\n".
        "APP_DEBUG=false\n".
        "APP_URL={$url}\n\n".
        "LOG_CHANNEL=daily\n\n".
        "DB_CONNECTION=". $request->input('database_connection') ."\n".
        "DB_HOST=". $request->input('database_hostname') ."\n".
        'DB_PORT='. $request->input('database_port') ."\n".
        'DB_DATABASE='. $request->input('database_name') ."\n".
        'DB_USERNAME='. $request->input('database_username') ."\n".
        'DB_PASSWORD="'. $request->input('database_password') .'"'."\n".
        'DB_PREFIX='. $request->input('database_prefix', 'jw_') ."\n\n".
        "BROADCAST_DRIVER=log\n".
        "CACHE_DRIVER=file\n".
        "SESSION_DRIVER=file\n".
        "SESSION_LIFETIME=120\n".
        "QUEUE_DRIVER=sync\n\n".
        "REDIS_HOST=127.0.0.1\n".
        "REDIS_PASSWORD=null\n".
        "REDIS_PORT=6379\n\n".
        "MAIL_DRIVER=smtp\n".
        "MAIL_HOST=smtp.mailtrap.io\n".
        "MAIL_PORT=2525\n".
        "MAIL_USERNAME=null\n".
        "MAIL_PASSWORD=null\n".
        "MAIL_ENCRYPTION=null\n\n".
        "MAIL_FROM_NAME=\n".
        "MAIL_FROM_ADDRESS=\n\n".
        "PUSHER_APP_ID=\n".
        "PUSHER_APP_KEY=\n".
        "PUSHER_APP_SECRET=\n".
        "PUSHER_APP_CLUSTER=mt1\n";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('cms::installer.environment.errors');
        }

        return $results;
    }
}
