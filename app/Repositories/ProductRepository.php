<?php


namespace App\Repositories;


use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($request, $id){
        $product = $this->findById($id);
        $product->update($request);

        return $product;
    }

    public function index(){
        return $this->model->getAll();
    }

    public function destroy($product){
        return $product->delete();
    }
}
