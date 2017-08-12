<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/7/2017
 * Time: 6:07 PM
 */

namespace Infustructure\Storage\Message;

use domain\message;
use domain\user;

interface MessageRepoPort
{
    public function read($chatroomID);
    public function readDateRange($chatroomID, $begin, $end);
    public function write($chatroom, message $message, user $user);
}
