<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 8/11/2017
 * Time: 10:14 PM
 */

namespace Infustructure\Storage\Client;


interface ClientRepoPort
{
    public function isValidKey($key);

}