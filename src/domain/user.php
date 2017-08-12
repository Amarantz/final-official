<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 7/30/2017
 * Time: 2:10 PM
 */

namespace Domain;

use PHPUnit\Runner\Exception;

class User
{
    protected $userID;
    protected $uuid;
    protected $username;
    protected $email;


    public function __construct()
    {
        $this->uuid = uniqid('user_');
    }

    public function setUsername($username)
    {
        if (empty($username)) {
            throw new Exception("We don't have a username");
        }
        $this->username = $username;
        return $this;
    }

    public function setEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this;
        }
        $this->email = $email;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setUserID($userID)
    {
        if (!is_numeric($userID)) {
            return $this;
        }
        $this->userID = $userID;
        return $this;
    }

    public function getUUID()
    {
        return $this->uuid;
    }

    public function getUserID()
    {
        return $this->userID;
    }
    public function setUUID($uuid)
    {
        if (!isset($uuid)) {
            throw new \Exception("Missing UUID to attach");
        }
        $this->uuid = $uuid;
        return $this;
    }

    public function jsonString()
    {
        $arr[] = [
            "userID" => $this->userID,
            "username" => $this->username,
            "email" => $this->email,
            "uuid" => $this->uuid
        ];
        return json_encode($arr, JSON_PRETTY_PRINT);
    }
}
