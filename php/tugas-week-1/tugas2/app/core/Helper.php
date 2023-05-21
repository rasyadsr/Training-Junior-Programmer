<?php

use App\Core\Response;

function respone(): Response
{
    return new Response;
}

function view($viewName)
{
    require_once __DIR__ . "./../view/templates/header.phtml";
    require_once __DIR__ . "./../view/" . $viewName . ".phtml";
    require_once __DIR__ . "./../view/templates/footer.phtml";
}
