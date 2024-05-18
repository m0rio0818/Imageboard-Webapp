<?php

require __DIR__ . "/../vendor/autoload.php";

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Server\Server;
// use React\EventLoop\Loop;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Server()
        )
    ),
    8080
);


$server->run();