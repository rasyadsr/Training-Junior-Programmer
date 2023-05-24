<?php

namespace App\Core;

class Model
{

    protected \PDO $connection;

    public function __construct()
    {
        $database =  new Database();
        $this->connection = $database->connect();
    }

    // TODO: buat fungsi yang reusable
    public function whereClause()
    {
        # code...
    }
}
