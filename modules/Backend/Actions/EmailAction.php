<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
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
    public function handle(): void
    {
        $this->addAction(Action::INIT_ACTION, [$this, 'addEmailTemplates']);
        $this->addAction(Action::BACKEND_INIT, [$this, 'addPages']);
    }

    public function addPages(): void
    {
        $this->hookAction->registerAdminPage(
            'email-hooks',
            [
                'title' => trans('cms::app.email_hooks'),
                'menu' => [
                    'icon' => 'fa fa-envelope',
                    'position' => 60,
                    'parent' => 'managements',
                    'permissions' => [
                        'email_hooks.index',
                        'email_hooks.edit',
                        'email_hooks.create',
                        'email_hooks.delete',
                    ],
                ]
            ]
        );
    }

    /**
     * Add Email templates.
     *
     * Loops through a directory and adds all the email templates we've configured to the CMS
     */
    public function addEmailTemplates(): void
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
