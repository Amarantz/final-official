<?php

$dic = $app->getContainer();
$settings = $dic->get('settings')['database'];

$dic['mysql'] = function ($dic) use ($settings) {
    $c = $settings[0]['connections']['mysql'];
    $pdo = new PDO(
        $c['driver'].':host='.$c['host'].';dbname='.$c['database'].';port='.$c['port'],
        $c['username'],
        $c['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$dic['redis'] = function ($dic) use ($settings) {
    $c = $settings[0]['connections']['redis'];
    $redis = \storage\connectToRedis($c['default']['host'], $c['default']['port']);
    return $redis;
};


