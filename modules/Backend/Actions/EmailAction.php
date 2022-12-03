<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Abstracts\Action;

class EmailAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'addEmailTemplates']);
    }

    public function addEmailTemplates()
    {
        $basePath = base_path('modules/Backend/resources/data/mail_templates');
        $files = File::files($basePath);

        foreach ($files as $file) {
            if ($file->getExtension() != 'json') {
                continue;
            }

            $code = $file->getFilenameWithoutExtension();
            $data = json_decode(File::get($file->getRealPath()), true);

            $this->hookAction->registerEmailTemplate(
                $code,
                [
                    'subject' => Arr::get($data, 'subject'),
                    'body' => "cms::email.{$code}",
                    'params' => Arr::get($data, 'params'),
                ]
            );
        }
    }
}
