<?php


namespace App\Repositories\Contracts;


interface ProductRepositoryInterface
{
    public function store(array $data);

    public function findById($id);

    public function update($data, $id);

    public function index();
}
