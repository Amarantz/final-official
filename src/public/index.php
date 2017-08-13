<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 7/21/2017
 * Time: 8:46 PM
 */
include __DIR__.'/../c3.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Infustructure\Storage as Storage;
use \domain\user;
use \domain\Chatroom;
use \domain\Message;


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../settings.php';
$app = new \Slim\App($settings);
require __DIR__ . '/../dependencies.php';
require __DIR__ . '/../routes.php';
$app->run();
