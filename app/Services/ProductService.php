<?php

namespace App\Services;

use App\Helpers\ApiCommonResponses;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductService
{
    protected $repository;
    protected $apiCommonResponses;
    public function __construct(ApiCommonResponses $apiCommonResponses,ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->apiCommonResponses = $apiCommonResponses;
    }

    public function store(Request $request){
        $image = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/product'), $image);
        $product = $this->repository->store([
            'title'=> $request->get('title'),
            'description'=> $request->get('description'),
            'price' => $request->get('price'),
            'image' => $image,
        ]);
        $product['image'] = $this->getFullImagePath($product['image']);
        return $this->apiCommonResponses
            ->message('Product Created Successfully')
            ->successResponse(['product' => $product]);
    }


    public function update($request, $id){
        $product = $this->repository->findById($id);
        $requestData = $request->all();
        if($request->image != '' && $request->hasFile('image')){
            $path = $this->getProductUploadImageDirectory();

            //remove old file
            if($product->image != ''  && $product->image != null){
                $file_old = $path .'/'. $product->image;
                $this->removeFileFromServer($file_old);
            }
            $image = time() . '.' . $request->image->extension();
            $request->image->move($path, $image);
            $requestData['image'] = $image;

        }else{
            unset($requestData['image']);
        }

        $product = $this->repository->update($requestData, $id);
        $product['image'] = $this->getFullImagePath($product['image']);

        return $this->apiCommonResponses
            ->message('Product Updated Successfully')
            ->successResponse(['product' => $product]);
    }

    public function index(){
        $products = $this->repository->index();
        $formattedProduct = array();
        foreach ($products as $product){
            $product->image = $this->getFullImagePath($product->image);
            $formattedProduct[] = $product;
        }
        return $this->apiCommonResponses
            ->successResponse(['products' => $formattedProduct]);
    }

    public function destroy($id){
        $product = $this->repository->findById($id);
        $path = $this->getProductUploadImageDirectory();

        //remove old file
        if($product->image != ''  && $product->image != null){
            $file_old = $path .'/'. $product->image;
            $this->removeFileFromServer($file_old);
        }

        $this->repository->destroy($product);

        return $this->apiCommonResponses
            ->message('Product Deleted Successfully')
            ->successResponse([]);
    }

    public function removeFileFromServer($path){
        if (is_file($path)) unlink($path);
    }

    public function getProductUploadImageDirectory(){
        return public_path('uploads/product');
    }

    public function getFullImagePath($path){
        return 'http://127.0.0.1:8000/uploads/product/'. $path;
    }
}
