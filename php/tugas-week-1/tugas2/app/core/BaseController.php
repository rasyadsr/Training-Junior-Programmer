<?php

namespace App\Core;

class BaseController
{
    public function getQueryParam(): array
    {
        $arrayQueryParam = [];

        foreach ($_GET as $key => $value) {
            $arrayQueryParam[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $arrayQueryParam;
    }

    public function getPayload(): array
    {
        $arrayPayload = [];

        foreach ($_POST as $key => $value) {
            $arrayPayload[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        return $arrayPayload;
    }
}
