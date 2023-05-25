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
    public function whereClause($params): array
    {
        $executeParam = [];
        $whereClause = "";

        // Where Clause
        if (array_key_exists('where', $params)) {
            $conditions = [];
            foreach ($params['where'] as $column => $value) {
                $conditions[] = "$column = :$column";
                $executeParam[$column] = $value;
            }
            $whereClause = ' WHERE ' . implode(' AND ', $conditions);
        }

        // WhereLike Clause
        if (array_key_exists('whereLike', $params)) {
            $likeConditions = [];
            foreach ($params['whereLike'] as $column => $value) {
                $likeConditions[] = "$column LIKE :$column";
                $executeParam[$column] = '%' . $value . '%';
            }
            $whereClause .= ($whereClause ? ' AND ' : ' WHERE ') . implode(' AND ', $likeConditions);
        }

        return [$executeParam, $whereClause];
    }
}
