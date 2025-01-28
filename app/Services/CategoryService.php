<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function __construct(protected CategoryRepository $categoryRepository) {}

    public function findAllCategory(array $filters): LengthAwarePaginator
    {
        $filters['search']  ??= null;
        $filters['perPage'] ??= 10;
        $filters['page']    ??= 1;

        return $this->categoryRepository->findAllCategory($filters);
    }

    public function createCategory(array $data): Category
    {
        return $this->categoryRepository->createCategory($data);
    }

    public function updateCategory(Category $category, array $data): Category
    {
        return $this->categoryRepository->updateCategory($category, $data);
    }

    public function deleteCategory(Category $category): bool
    {
        return $this->categoryRepository->deleteCategory($category);
    }
}
