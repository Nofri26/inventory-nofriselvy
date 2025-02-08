<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(protected Category $category) {}

    public function findAll(): Collection
    {
        return $this->category->newQuery()->select(['id', 'name'])->get();
    }

    public function getAllPaginated(array $filters): LengthAwarePaginator
    {
        $category = $this->category->newQuery()->where(function(Builder $builder) use ($filters) {
            $search = $filters['search'] ?? null;
            if (! empty($search)) {
                $builder->orWhere('name', 'LIKE', "%$search%");
            }
        });

        return $category->paginate(perPage: $filters['perPage'], page: $filters['page']);
    }

    public function create(array $data): Category
    {
        return $this->category->newQuery()->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);

        return $category;
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
