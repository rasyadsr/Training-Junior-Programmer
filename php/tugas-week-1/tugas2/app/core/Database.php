<?php

namespace App\Core;

class Database
{

    private ?\PDO $connection = null;

    public function connect(): \PDO
    {
        if ($this->connection === null) {
            try {
                $this->connection = new \PDO("mysql:host=localhost;dbname=my_snippet", "root", "");
            } catch (\Exception $ex) {
                error_log("Error connectiong to database : " . $ex->getMessage());
            }
        }
        return $this->connection;
    }
}
