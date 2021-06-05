<?php

return [
    /**
     * Supported: "sync, queue, cron"
     * Default: sync
     * */
    'method' => 'sync',
    /**
     * Supported: "database, mail"
     * */
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
