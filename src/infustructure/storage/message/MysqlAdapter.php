<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/7/2017
 * Time: 6:11 PM
 */

namespace Infustructure\Storage\Message;

use domain\message;
use domain\user;
use domain\Chatroom;

require_once __DIR__.'/MessageRepoPort.php';
class MysqlAdapter implements MessageRepoPort
{
    protected $mysql;

    public function __construct(\PDO $mysql)
    {
        $this->mysql = $mysql;
    }

    public function read($chatroomID)
    {
        $sql = 'select username, messages, chatroomID, timeStamp from messages where chatroomid = :chatroomID order by TIMESTAMP desc';
        $result = $this->mysql->prepare($sql);
        $result->bindParam(':chatroomID', $chatroomID, 1);
        $result->execute();
        $data = $result->fetchAll();
        $m = [];
        if (is_array($data)) {
            foreach ($data as $d) {
                $mess = new Message();
                $mess->setUser($d['username'])->setMessage($d['messages'])->setChatroomID($chatroomID)
                    ->setTimeStamp($d['timeStamp']);
                $m[] = $mess;
            }
        }
        return $m;
    }

    public function readDateRange($chatroomID, $begin, $end)
    {
        $sql = 'select timestamp, username, messages , chatroomID from messages
                where chatroomID = :chatroomID and timeStamp >= :begin and timestamp <= :end
                order by timestamp desc';
        $st = $this->mysql->prepare($sql);
        $st-> bindParam(':chatroomID', $chatroomID);
        $st-> bindParam(':begin', $begin);
        $st-> bindParam(':end', $end);
        $st->execute();

        $result = $st->fetchAll();
        $m = [];
        if (is_array($result)) {
            foreach ($result as $d) {
                $mess = new Message();
                $mess->setUser($d['username'])->setMessage($d['messages'])->setChatroomID($chatroomID)
                    ->setTimeStamp($d['timeStamp']);
                $m[] = $mess;
            }
        }
        return $m;

    }

    public function write(Chatroom $chatroom, message $message)
    {
        $username = $message->getUser()->getUsername();
        $chatroomID = $chatroom->chatroomID();
        $message = $message->getMessage();
        $sql = 'insert into messages (chatroomID, messages, username, timpeStamp) values (:chatroomID,:message,:username, NOW())';
        $st = $this->mysql->prepare($sql);
        $st->bindParam(':chatroomID',$chatroomID);
        $st->bindParam(":message",$message);
        $st->bindParam(':username',$username);
        $st->execute();
    }
}
