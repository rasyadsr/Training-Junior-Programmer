<?php

namespace App\Model;

use App\Core\Model;

class SnippetType extends Model implements IModel
{

    public string $snippet_type_id;
    public string $snippet_type_name;

    public function loadList($params = [])
    {
        $result = null;
        $statement = $this->connection->query("SELECT snippet_type_id, snippet_type_name FROM snippet_type");
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function load(array $params)
    {
        $sql = "SELECT snippet_type_id, snippet_type_name FROM snippet_type";

        [$executeParam, $whereClause] = $this->whereClause($params);

        try {
            $statement = $this->connection->prepare($sql . $whereClause);
            $statement->execute($executeParam);
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $ex) {
            log_danger($ex);
        }
    }

    public function insert(array $data)
    {
        try {
            $statement = $this->connection->prepare("INSERT INTO snippet_type(snippet_type_name) VALUES(?)");
            $statement->execute([$data['snippet_type_name']]);
        } catch (\Exception $ex) {
            log_danger($ex);
        }
    }

    public function update(array $data)
    {
    }

    public function delete(string $id)
    {
    }
}
