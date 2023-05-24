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

    public function load(string $id)
    {
        
    }

   public function insert(array $data)
   {
    
   }

   public function update(array $data)
   {
    
   }

   public function delete(string $id)
   {
    
   }
}
