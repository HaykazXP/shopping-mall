<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoryResource;
use App\Services\ProductService;
use Illuminate\Http\Response;
use Exception;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        try {
            $products = $this->productService->getAllProducts();
            return ProductResource::collection($products);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve products.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request->all());
            return new ProductResource($product, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to create product.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->getProductById($id);
            return new ProductWithCategoryResource($product);
        } catch (Exception $e) {
            return response()->json(['error' => 'Product not found.'], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = $this->productService->updateProduct($id, $request->only(['title', 'description', 'price', 'category_id']));
            return new ProductResource($product);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to update product.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $this->productService->deleteProduct($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to delete product.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
