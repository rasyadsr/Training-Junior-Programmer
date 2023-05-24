<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . './../app/core/Bootstrap.php';

use App\Core\Request, App\Core\Response;

$app = new \App\Core\Route();

// $app->get("/", function (Request $req, Response $res) {
//     $res->status(403)->json([
//         'query_param' => $req->getQueryParam()
//     ]);
// });


// $app->get("/hello", [\App\Controller\SnippetController::class, 'index']);

$app->get("/", [\App\Controller\HomeController::class, 'index']);

/** Snippet */
$app->get("/snippets", [\App\Controller\SnippetController::class, 'index']);
$app->post("/snippets", [\App\Controller\SnippetController::class, 'store']);
$app->get("/snippets/([0-9]*)", [\App\Controller\SnippetController::class, 'show']);
$app->post("/snippets/update", [\App\Controller\SnippetController::class, 'update']);
$app->get("/snippets/delete/([0-9]*)", [\App\Controller\SnippetController::class, 'destroy']);

$app->listen();
