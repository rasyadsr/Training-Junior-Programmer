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

    public function findAll(): array
    {
        $result = null;

        $statement = $this->connection->query("SELECT snippet_id, title, snippet_type_id, code, created_by FROM snippets");

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public function findById()
    {
    }

    public function insert(array $data = []): int
    {
        try {
            $statement = $this->connection->prepare("INSERT INTO snippets(title, snippet_type_id, code, created_by) VALUES(?, ?, ?, ?)");
            $statement->execute([$data['title'], $data['snippet_type_id'], $data['code'], $data['created_by']]);
        } catch (\PDOException $ex) {
            error_log($ex->getMessage() . " baris " .  $ex->getLine());
        }

        return $statement->rowCount();
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
