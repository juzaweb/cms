<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */
namespace Juzaweb\Logging;

use Illuminate\Http\Request;

class AddCustomInformation
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function __invoke($logger)
    {
        if ($this->request) {
            foreach ($logger->getHandlers() as $handler) {
                $handler->pushProcessor([$this, 'processLogRecord']);
            }
        }
    }

    public function processLogRecord(array $record): array
    {
        $record['extra'] += [
            'user' => $this->request->user()->id ?? 'guest',
            'ip' => get_client_ip(),
            'url' => $this->request->fullUrl(),
        ];

        return $record;
    }
}
