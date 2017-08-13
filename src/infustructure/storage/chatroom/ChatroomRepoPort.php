<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/11/2017
 * Time: 9:13 PM
 */

namespace Infustructure\Storage\Chatroom;

interface ChatroomRepoPort
{
    public function write(\Domain\Chatroom $chatroom);
    public function readAll();
    public function read($id);
    public function deactivate();
    public function updateActiveDate($id);
    public function updateChatroom(\Domain\Chatroom $chatroom);
}
