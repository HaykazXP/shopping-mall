<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            return response()->json(Category::get());
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve categories.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create($request->all());

            return response()->json($category, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to create category.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);

            return response()->json($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve category.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->only(['title', 'description']));

            return response()->json($category);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to update category.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            Category::destroy($id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to delete category.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
