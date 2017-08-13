<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/6/2017
 * Time: 11:51 AM
 */
return [
    'fetch' => PDO::FETCH_ASSOC,
    'default' => 'mysql',
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host'  => 'mysql',
            'database' => 'cs3620',
            'port' => 3306,
            'username' => 'fo1',
            'password' => 'bar',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ],
        'redis' =>  [
            'cluster' => 'false',
            'default' =>  [
                'host' => 'redis',
                'port' => 6379,
                'database' => 0
            ]
        ]
    ]

];
