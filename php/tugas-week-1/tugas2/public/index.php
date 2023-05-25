<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . './../app/core/Bootstrap.php';

use App\Controller\AuthController;
use App\Core\Request, App\Core\Response;

$app = new \App\Core\Route();

// $app->get("/", function (Request $req, Response $res) {
//     $res->status(403)->json([
//         'query_param' => $req->getQueryParam()
//     ]);
// });


// $app->get("/hello", [\App\Controller\SnippetController::class, 'index']);

$app->get("/", [\App\Controller\HomeController::class, 'index'], [\App\Middleware\AuthMiddleware::class]);

// Snippet
$app->get("/snippets", [\App\Controller\SnippetController::class, 'index'], [\App\Middleware\AuthMiddleware::class]);
$app->post("/snippets", [\App\Controller\SnippetController::class, 'store'], [\App\Middleware\AuthMiddleware::class]);
$app->get("/snippets/([0-9]*)", [\App\Controller\SnippetController::class, 'show'], [\App\Middleware\AuthMiddleware::class]);
$app->post("/snippets/update", [\App\Controller\SnippetController::class, 'update'], [\App\Middleware\AuthMiddleware::class]);
$app->get("/snippets/delete/([0-9]*)", [\App\Controller\SnippetController::class, 'destroy'], [\App\Middleware\AuthMiddleware::class]);

// Auth
$app->get("/login", [\App\Controller\AuthController::class, 'login']);
$app->post("/login", [\App\Controller\AuthController::class, 'loginStore']);

$app->get("/register", [AuthController::class, 'register']);
$app->post("/register", [AuthController::class, 'registerStore']);

$app->get("/logout", [\App\Controller\AuthController::class, 'logout']);

// Snippet Type
$app->post("/snippet-type", [\App\Controller\SnippetTypeController::class, 'store'], [\App\Middleware\AuthMiddleware::class]);
$app->get("/snippet-type", [\App\Controller\SnippetTypeController::class, 'index'], [\App\Middleware\AuthMiddleware::class]);

$app->listen();
