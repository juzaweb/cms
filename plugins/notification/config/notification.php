<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 */

return [
    /**
     * Method send notification
     *
     * Support: sync, queue, cron
     * Default: sync
     */
    'method' => 'sync',

    /**
     * Send mail via
     *
     * Support: database, mail
     */
    'via' => [
        'database' => [
            'enable' => true,
        ],
        'mail' => [
            'enable' => true,
            'connection' => 'default',
        ]
    ]
];
