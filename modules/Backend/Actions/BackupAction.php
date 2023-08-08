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

use Juzaweb\CMS\Abstracts\Action;

class BackupAction extends Action
{
    /**
     * Handle the action execution
     *
     * @return void
     */
    public function handle(): void
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addConfigs']);
    }

    /**
     * Add backup configurations
     *
     * This method adds configurations to enable and set up time for backup.
     *
     * @return void
     */
    public function addConfigs(): void
    {
        $this->hookAction->registerConfig(
            [
                'jw_backup_enable' => [
                    'form' => 'backup',
                    'type' => 'select',
                    'label' => trans('cms::app.backup.enable_backup'),
                    'data' => [
                        'options' => [
                            0 => trans('cms::app.disabled'),
                            1 => trans('cms::app.enabled'),
                        ]
                    ]
                ],
                'jw_backup_time' => [
                    'form' => 'backup',
                    'type' => 'select',
                    'label' => trans('cms::app.backup.backup_time'),
                    'data' => [
                        'options' => [
                            'daily' => 'Daily',
                            'weekly' => 'Weekly',
                            'monthly' => 'Monthly',
                        ]
                    ]
                ]
            ]
        );

        $this->hookAction->addSettingForm(
            'backup',
            [
                'name' => trans('cms::app.backup.backup_setting'),
                'priority' => 99,
            ]
        );
    }
}
