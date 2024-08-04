<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        try {
            return response()->json(Product::with('category')->get());
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve products.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $sku = $this->generateUniqueSku();

            $product = Product::create(array_merge($request->all(), ['sku' => $sku]));

            return response()->json($product, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to create product.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);

            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve product.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateProductRequest $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->update($request->only(['title', 'description', 'price', 'category_id']));

            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to update product.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            Product::destroy($id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Product not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to delete product.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function generateUniqueSku()
    {
        do {
            $sku = strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());
        
        return $sku;
    }
}
