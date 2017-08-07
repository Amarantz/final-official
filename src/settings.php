<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 7/21/2017
 * Time: 8:48 PM
 */
$settings = [
    'settings' => [
        'displayErrorDetails' => true,

        'logger' => [
            'name' => 'chatroom_log',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log'
        ],

        'database' => [include __DIR__ .'/config/database.php']
    ]
];