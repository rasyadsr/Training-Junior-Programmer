<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Request, App\Core\Response;

$app = new \App\Core\Route();

$app->get("/", function (Request $req, Response $res) {
    $res->status(403)->json([
        'query_param' => $req->getQueryParam()
    ]);
});


$app->get("/hello", [\App\Controller\SnippetController::class, 'index']);

$app->listen();
