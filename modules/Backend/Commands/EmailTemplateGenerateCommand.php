<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Juzaweb\Backend\Models\EmailTemplate;

class EmailTemplateGenerateCommand extends Command
{
    protected $signature = 'mail:generate-template';

    public function handle(): int
    {
        $basePath = base_path('modules/Backend/resources/data/mail_templates');
        $files = File::files($basePath);

        foreach ($files as $file) {
            if ($file->getExtension() != 'json') {
                continue;
            }

            $code = $file->getFilenameWithoutExtension();
            $data = json_decode(File::get($file->getRealPath()), true);

            EmailTemplate::firstOrCreate(
                [
                    'code' => $code,
                ],
                [
                    'subject' => Arr::get($data, 'subject'),
                    'body' => File::get("{$basePath}/{$code}.twig"),
                    'params' => Arr::get($data, 'params'),
                ]
            );

            $this->info("Created email template: {$code}");
        }

        return self::SUCCESS;
    }
}
