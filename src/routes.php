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

$app->get('/user/{id}', function (Request $req, Response $resp, $args) {
    $key = $req->getHeaderLine('x-api-key');
    if (!$this->api_key_Validation->isValidKey($key)){
        $resp = $resp->withAddedHeader('Error',"Invalid Key has been pushed");
        return $resp->withStatus(417);
    }

    $user = $this->userAdapter->read($args['id']);
    $resp = $resp->withJson($user->arr());
    return $resp->withStatus(202);
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
        $resp = $resp->withAddedHeader('Error',"Invalid Key has been pushed");
        return $resp->withStatus(417);
    }
    $user = $this->newUser;
    $body = $req->getParsedBody();
    $user->setUsername($body['username']);
    $user->setEmail($body['email']);

    $this->userAdapter->write($user);
    $user = $this->userAdapter->read($user->getUUID());
    $resp = $resp->withHeader('allowed', 'User created');
    $resp = $resp->withoutHeader('Content-Type');
    $resp = $resp->withHeader('Content-Type','application/json');
    $resp = $resp->withJson($user->arr());

    return $resp->withStatus(202);
});

$app->get('/chatroom/list', function(Request $req, Response $resp) {
    $key = $req->getHeaderLine('x-api-key');
    if (!$this->api_key_Validation->isValidKey($key)){
        $resp = $resp->withAddedHeader('Error',"Invalid Key has been pushed");
        return $resp->withStatus(417);
    }

    $cr = $this->chatroomAdapter->readAll();
    $r;
    foreach ($cr as $room)
    {
        $name = $room->name();
        $subject = $room->subject();
        $chatroomID = $room->chatroomID();
        $r[] = [
            'name'=>$name,
            'subject'=>$subject,
            'chatroomID'=>$chatroomID
        ];
    }
    $resp = $resp->withJson($r);

    return $resp->withStatus(202);

});
$app->get('/chatroom/{id}',function(Request $req, Response $resp, $args){
    $key = $req->getHeaderLine('x-api-key');
    if (!$this->api_key_Validation->isValidKey($key)){
        $resp = $resp->withAddedHeader('Error',"Invalid Key has been pushed");
        return $resp->withStatus(417);
    }
});

$app->post('/chatroom/{id}',function(Request $req, Response $resp, $args){
    $key = $req->getHeaderLine('x-api-key');
    if (!$this->api_key_Validation->isValidKey($key)){
        $resp = $resp->withAddedHeader('Error',"Invalid Key has been pushed");
        return $resp->withStatus(417);
    }
    $json = $req->getParsedBody();
    if (!is_string($json['username']) || !is_string($json['email']) || !is_string($json['uuid']))
    {
        $resp = $resp->withHeader('Error', 'Missing Users Info');
        return $resp->withStatus(417);
    }
});

$app->post('/chatroom/{id}/join',function(Request $req, Response $resp, $args){
    $key = $req->getHeaderLine('x-api-key');
    if (!$this->api_key_Validation->isValidKey($key)){
        $resp = $resp->withAddedHeader('Error',"Invalid Key has been pushed");
        return $resp->withStatus(417);
    }

    $json = $req->getParsedBody();
    if (!is_string($json['username']) || !is_string($json['email']) || !is_string($json['uuid']))
    {
        $resp = $resp->withHeader('Error', 'Missing Users Info');
        return $resp->withStatus(417);
    }
    $cr = $this->chatroomAdapter->read($args['id']);

    $user = $this->userAdapter->read($json['uuid']);

    $cr->join($user);

    $cr = $this->chatroomAdapter->updateChatroom($cr);

    $c = new \Domain\Chatroom();
    $c->setSubject($cr->subject());
    $c->setUUID($cr->uuid());
    $c->setname($cr->name());
    $c->setChatroomID($cr->chatroomID());
    $members = $cr->members();
    foreach ($members as $m) {
        $uuid = $m->getUUID();
        $user = $this->userAdapter->read($uuid);
        $c->join($user);
    }



    $messages = $this->messageAdapter->read($c->chatroomID());
    foreach ($messages as $message)
    {
        $c->addMessages($message);
    }


    $resp = $resp->withJson($c->arr());
    return $resp->withStatus(202);


});


$app->post('/chatroom/{id}/leave',function(Request $req, Response $resp, $args){
    $key = $req->getHeaderLine('x-api-key');
    if (!$this->api_key_Validation->isValidKey($key)){
        $resp = $resp->withAddedHeader('Error',"Invalid Key has been pushed");
        return $resp->withStatus(417);
    }

    $json = $req->getParsedBody();
    if (!is_string($json['username']) || !is_string($json['email']) || !is_string($json['uuid']))
    {
        $resp = $resp->withHeader('Error', 'Missing Users Info');
        return $resp->withStatus(417);
    }
});