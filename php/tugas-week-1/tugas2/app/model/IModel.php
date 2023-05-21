<?php

namespace App\Model;

interface IModel
{

    public function findAll();

    public function findById();

    public function insert();

    public function update();

    public function delete();
}
