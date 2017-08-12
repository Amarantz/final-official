<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/11/2017
 * Time: 10:15 PM
 */

namespace Infustructure\Storage\Client;
require __DIR__.'/ClientRepoPort.php';

class MysqlAdapter implements ClientRepoPort
{
    protected $mysql;

    public function __construct(\PDO $pdo)
    {
        $this->mysql = $pdo;
    }

    public function isValidKey($key)
    {
        $sql = 'select clientID, Token from client where token = :key';
        $st = $this->mysql->prepare($sql);
        $st->bindParam(':key', $key);
        $st->execute();
        $result = $st->rowCount();
        if ($result == 1) {
            return true;
        }
        return false;
    }
}