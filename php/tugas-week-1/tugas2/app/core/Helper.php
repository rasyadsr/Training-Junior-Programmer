<?php

use App\Core\Response;

function response(): Response
{
    return new Response;
}

function view($viewName, $data = [])
{
    require_once __DIR__ . "./../view/templates/header.phtml";
    require_once __DIR__ . "./../view/" . $viewName . ".phtml";
    require_once __DIR__ . "./../view/templates/footer.phtml";
}

/**
 * Buat error_log biar simple aja
 */
function log_danger(Exception $ex)
{
    error_log("Error :" . $ex->getMessage() . " file " . $ex->getFile() . " baris " . $ex->getLine());
}
