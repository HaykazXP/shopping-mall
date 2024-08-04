<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Response;
use Exception;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        try {
            $categories = $this->categoryService->getAllCategories();
            return CategoryResource::collection($categories);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve categories.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->categoryService->createCategory($request->all());
            return new CategoryResource($category, Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to create category.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return new CategoryResource($category);
        } catch (Exception $e) {
            return response()->json(['error' => 'Category not found.'], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryService->updateCategory($id, $request->only(['title', 'description']));
            return new CategoryResource($category);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to update category.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to delete category.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
