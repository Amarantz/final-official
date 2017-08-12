<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/7/2017
 * Time: 5:35 PM
 */

namespace Infustructure\Storage\User;

use domain\user;

interface UserRepoPort
{
    public function read($id);
    public function remove($id);
    public function write(user $user);
}
