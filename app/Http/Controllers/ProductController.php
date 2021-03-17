<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Requests\Product\Create;

class ProductController extends Controller
{
    protected $service;
    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function store(Create $request){
        return $this->service->store($request);
    }

    public function update(Create $request, $id){
        return $this->service->update($request, $id);
    }

    public function destroy($id){
        return $this->service->destroy($id);
    }


}
