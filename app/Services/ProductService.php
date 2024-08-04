<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductService
{
    protected $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function getAllProducts()
    {
        return $this->productRepo->all();
    }

    public function getProductById($id)
    {
        return $this->productRepo->find($id);
    }

    public function createProduct(array $data)
    {
        $data['sku'] = $this->generateUniqueSku();
        return $this->productRepo->create($data);
    }

    public function updateProduct($id, array $data)
    {
        return $this->productRepo->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->productRepo->delete($id);
    }

    private function generateUniqueSku()
    {
        do {
            $sku = strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }
}
