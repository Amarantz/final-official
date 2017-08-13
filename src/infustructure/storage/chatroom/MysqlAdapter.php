<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/11/2017
 * Time: 9:17 PM
 */

namespace Infustructure\Storage\Chatroom;
use Domain\Chatroom;
use domain\user;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\DocCommentAlignmentSniff;

require __DIR__.'/ChatroomRepoPort.php';

class MysqlAdapter implements ChatroomRepoPort
{
    protected $mysql;

    public function __construct(\PDO $pdo)
    {
        $this->mysql = $pdo;
    }

    public function write(Chatroom $chatroom)
    {
        $name = $chatroom->name();
        $subject = $chatroom->subject();
        $uuid = $chatroom->uuid();
        $sql = 'insert into chatroom (`name`,`subject`,`uuid`,`active`,`lastactivedate`) 
                values (:name,:subject,:uuid, 1,NOW())';
        $st = $this->mysql->prepare($sql);
        $st->bindParam(':name', $name);
        $st->bindParam(':subject', $subject);
        $st->bindParam(':uuid', $uuid);
        return $st->execute();
    }

    public function read($id)
    {
        $sql = 'select chatroomID, name, subject, active, lastActiveDate, UUID from chatroom where chatroomID = :ID';
        $st = $this->mysql->prepare($sql);
        $st->bindParam(':ID', $id);
        $st->execute();
        $result = $st->fetch();
        $cr = new Chatroom();
        $cr->setUUID($result['UUID'])->setName($result['name'])->setSubject($result['subject'])
            ->setchatroomID($result['chatroomID'])->setActive($result['active'])
            ->setLastActiveDate($result['lastActiveDate']);
        $sql = 'select userUUID from chatroomUsers where chatroomID=:ID';
        $st = $this->mysql->prepare($sql);
        $st->bindParam(':ID',$id);
        $st->execute();
        $result = $st->fetchAll();

        foreach($result as $m)
        {
            $u = new user();
            $u->setUUID($m['userUUID']);
            $cr->join($u);
        }
        return $cr;
    }

    public function readAll()
    {
        $sql = 'select chatroomID, name, subject, uuid, active, lastActiveDate from chatroom where active = 1 ';
        $st = $this->mysql->prepare($sql);
        $st->execute();
        $result = $st->fetchAll();
        $arr;
        foreach ($result as $data) {
            $c = new Chatroom();
            $c->setUUID($data['uuid'])->setName($data['name'])
                ->setSubject($data['subject'])->setActive($data['active'])
                ->setchatRoomID($data['chatroomID'])->setLastActiveDate($data['lastActiveDate']);
            $arr[] = $c;
        }
        return $arr;
    }

    public function deactivate()
    {
        $sql = 'update chatroom set active = 0 where datediff(NOW(),lastActiveDate) > 7';
        $st = $this->mysql->prepare($sql);
        $st->execute();
    }

    public function updateActiveDate($id)
    {
        $sql = 'update chatroom set lastActiveDate = NOW() where chatroomID = :ID';
        $st = $this->mysql->prepare($sql);
        $st->bindParam(':ID', $id);
        return $st->execute();
    }

    public function updateChatroom(Chatroom $chatroom)
    {
        if  (!$chatroom->updateFlag())
        {
            return;
        }
        $name = $chatroom->name();
        $subject = $chatroom->subject();
        $id = $chatroom->chatroomID();
        $sql = 'update chatroom set subject = :subject, lastActiveDate = NOW() where chatroomID = :id';

        $st = $this->mysql->prepare($sql);
        $st->bindParam(':subject', $subject);
        $st->bindParam('id', $id);
        $st->execute();

        $this->updateChatroomUserList($chatroom);
        return $this->read($chatroom->chatroomID());
    }

    public function updateChatroomUserList(Chatroom $chatroom)
    {
        $chatroomID = $chatroom->chatroomID();
        $members = $chatroom->members();
        $sql = 'delete from chatroomUsers where chatroomID = :ID';
        $st = $this->mysql->prepare($sql);
        $st->bindParam(':ID',$chatroomID);
        $st->execute();

        foreach ($members as $m)
        {
            $uuid = $m->getUUID();
            $sql = 'insert into chatroomUsers (chatroomID, userUUID) values (:chatroomID, :userUUID)';
            $st = $this->mysql->prepare($sql);
            $st->bindParam(':chatroomID',$chatroomID);
            $st->bindParam(':userUUID',$uuid);
            $st->execute();
        }
        return $this->read($chatroomID);
    }

}
