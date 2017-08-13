<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/11/2017
 * Time: 4:35 PM
 */

namespace Infustructure\Storage\User;

require_once __DIR__.'/UserRepoPort.php';

use domain\user;

class RedisAdapter implements UserRepoPort
{
    protected $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    public function read($id)
    {
        $something = json_decode($this->redis->get($id), true);
        $user = new user();
        $user->setUUID($something[0]['uuid'])->setUsername($something[0]['username'])
            ->setEmail($something[0]['email'])->setUserID($something[0]['userID']);
        return $user;
    }

    public function write(user $user)
    {
        $this->redis->set($user->getUUID(), $user->jsonString());
    }

    public function remove($id)
    {
        $this->redis->delete($id);
        return true;
    }
}
