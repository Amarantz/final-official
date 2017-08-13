<?php
require __DIR__.'/infustructure/storage/client/MysqlAdapter.php';
require __DIR__.'/infustructure/storage/chatroom/MysqlAdapter.php';
require __DIR__.'/infustructure/storage/user/RedisAdapter.php';
require __DIR__.'/infustructure/storage/message/MysqlAdapter.php';
require __DIR__.'/domain/user.php';
require __DIR__.'/domain/message.php';
require __DIR__.'/domain/chatroom.php';
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
    $redis = new Redis();
    $redis->connect($c['default']['host'], $c['default']['port']);
    return $redis;
};

$dic['newUser'] = function ($dic){
    $user = new \domain\user();
    return $user;
};

$dic['newMessage'] = function($dic){
    $message = new \domain\Messsage();
    return $message;
};

$dic['newChatroom'] = function($dic) {
    $chatroom = new domain\Chatroom();
    return $chatroom;
};

$dic['userAdapter'] = function($dic)  {
    $mysql = new \Infustructure\Storage\User\RedisAdapter($dic->redis);
    return $mysql;
};

$dic['chatroomAdapter'] = function($dic) {
    $mysql = new \Infustructure\Storage\Chatroom\MysqlAdapter($dic->mysql);
    return $mysql;
};

$dic['api_key_Validation'] = function ($dic){
    $mysql = new \Infustructure\Storage\Client\MysqlAdapter($dic->mysql);
    return $mysql;
};

$dic['messageAdapter'] = function ($dic){
    $mysql = new \Infustructure\Storage\Message\MysqlAdapter($dic->mysql);
    return $mysql;
};