<?php

namespace App\Model;

use App\Core\Model;

class User extends Model implements IModel
{
    public string $id;
    public string $email;
    public string $fullname;
    public string $password;

    public function loadList($params = [])
    {
    }

    public function load(array $params)
    {

        $sql = "SELECT id, email, `password`, fullname FROM users";

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
            $statement = $this->connection->prepare("INSERT INTO users(email, `password`, fullname) VALUES(?, ?, ?)");
            $statement->execute([$data['email'], $data['password'], $data['fullname']]);
            return $statement->rowCount();
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
