<?php

namespace App\Core;

use Database;

class Model
{

    protected \PDO $connection;

    public function __construct()
    {
        $database =  new Database();
        $this->connection = $database->connect();
    }
}
