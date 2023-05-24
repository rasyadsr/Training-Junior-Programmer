<?php

namespace App\Model;

use App\Core\Model;

interface IModel
{
    public function loadList($params = []);

    public function load(string $id);

    public function insert(array $data);

    public function update(array $data);

    public function delete(string $id);
}
