<?php
/**
 * Created by PhpStorm.
 * User: Blaine
 * Date: 7/21/2017
 * Time: 8:49 PM
 */

/*
 * GET /chatrooms   this should list the chatrooms available
 * GET /chatroom/{id}  this should list all the messages from the chatroom
 * GET /user/id  this should be able to get the details of the user account
 * POST /chatroom/join/{id}  this joins a new chatroom for the user
 * POST /user/create   this creates a new users and should run the user object?
 * POST /user/{id}        ths allows to update users
 * POST /chatroom/id?begin={begindate}?end={enddate}
 *
 */
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/user/{id}', function (Request $req, Response $resp) {
    return $resp;
});


$app->get('/', function (Request $req, Response $resp) {
    $uri = $req->getUri();
    $resp->withHeader('application', 'app/json');
    $resp->withHeader('uri', 'Http://'.$uri->getHost());
    $resp->withStatus(200);
    echo "<HTML><BODY><H1>WE HAVE NOTHING YOU WANT</H1></BODY>";
    return $resp;
});

$app->post('/user/create',function(Request $req, Response $resp){
    $key = $req->getHeaderLine('x-api-key');
    if (!$this->api_key_Validation->isValidKey($key)){
        $resp->withStatus(417);
    }
    $user = $this->newUser;
    $body = $req->getParsedBody();
    $user->setUsername($body['username']);
    $user->setEmail($body['email']);

    $this->userAdapter->write($user);

    print_r($user);

    return $resp;
});
