<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function findAllCategory(array $filters): LengthAwarePaginator;

    public function createCategory(array $data): Category;

    public function updateCategory(Category $category, array $data): Category;

    public function deleteCategory(Category $category): bool;
}
