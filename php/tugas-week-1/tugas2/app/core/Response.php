<?php

namespace App\Core;

class Response
{
    public function json(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function status(int $httpStatusCode): Response
    {
        http_response_code($httpStatusCode);
        return $this;;
    }
}
