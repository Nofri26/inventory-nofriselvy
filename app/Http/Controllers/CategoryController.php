<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function get(): JsonResponse
    {
        $categories = $this->categoryService->findAll();

        return $this->sendResponse(ApiResponse::RESPONSE_GET, CategoryResource::collection($categories));
    }

    public function index(Request $request): JsonResponse
    {
        $data     = $request->all();
        $category = $this->categoryService->getPaginatedCategories($data);

        return $this->sendResponse(ApiResponse::RESPONSE_GET, CategoryResource::collection($category), withMeta: true);
    }

    public function store(Categories\StoreCategoryRequest $request): JsonResponse
    {
        $data     = $request->validated();
        $category = $this->categoryService->createCategory($data);

        return $this->sendResponse(ApiResponse::RESPONSE_CREATE, new CategoryResource($category), responseCode: 201);
    }

    public function show(Category $category): JsonResponse
    {
        return $this->sendResponse(ApiResponse::RESPONSE_GET, new CategoryResource($category));
    }

    public function update(Categories\UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $data     = $request->validated();
        $category = $this->categoryService->updateCategory($category, $data);

        return $this->sendResponse(ApiResponse::RESPONSE_UPDATE, new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->deleteCategory($category);

        return $this->sendResponse(ApiResponse::RESPONSE_DELETE);
    }
}
