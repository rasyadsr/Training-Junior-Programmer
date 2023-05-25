<?php

namespace App\Model;

use App\Core\Model;

class Snippet extends Model implements IModel
{
    public string $snippet_id;
    public string $title;
    public string $snippet_type_id;
    public string $code;
    public string $created_by;

    public function loadList($params = []): array
    {
        $result = null;

        // Base Select
        $sql = "SELECT snippet_id, title, snippet_type_id, code, created_by FROM snippets";

        [$executeParam, $whereClause] = $this->whereClause($params);

        // Order Clause
        $orderClause = " ORDER BY snippet_id DESC";

        $statement = $this->connection->prepare($sql . $whereClause . $orderClause);
        $statement->execute($executeParam);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }


    public function load(array $params)
    {
        try {

            $sql = "SELECT snippet_id, title, snippet_type_id, code, created_by FROM snippets";

            [$executeParam, $whereClause] = $this->whereClause($params);

            $statement = $this->connection->prepare($sql . $whereClause);

            $statement->execute($executeParam);
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $ex) {
            log_danger($ex);
        }
    }

    public function insert(array $data = []): int
    {
        try {
            $statement = $this->connection->prepare("INSERT INTO snippets(title, snippet_type_id, code, created_by) VALUES(?, ?, ?, ?)");
            $statement->execute([$data['title'], $data['snippet_type_id'], $data['code'], $data['created_by']]);
        } catch (\PDOException $ex) {
            log_danger($ex);
        }

        return $statement->rowCount();
    }

    public function update(array $data)
    {
        try {
            $statement = $this->connection->prepare("UPDATE snippets SET title = ?, snippet_type_id = ?, code = ?, created_by = ? WHERE snippet_id = ?");
            $statement->execute([$data['title'], $data['snippet_type_id'], $data['code'], $data['created_by'], $data['snippet_id']]);
        } catch (\PDOException $ex) {
            log_danger($ex);
        }

        return $statement->rowCount();
    }

    public function delete(string $id)
    {
        try {
            $statement = $this->connection->prepare("DELETE FROM snippets WHERE snippet_id = ?");
            $statement->execute([$id]);
        } catch (\PDOException $ex) {
            log_danger($ex);
        }

        return $statement->rowCount();
    }
}
