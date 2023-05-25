<?php

namespace App\Model;

use App\Core\Model;

interface IModel
{
    public function loadList($params = []);

    public function load(array $data);

    public function insert(array $data);

    public function update(array $data);

    public function delete(string $id);
}
