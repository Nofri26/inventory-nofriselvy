<?php

namespace App\Repositories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class SizeRepository implements SizeRepositoryInterface
{
    public function __construct(protected Size $size) {}

    public function findAll(array $filters): LengthAwarePaginator
    {
        $sizes = $this->size->where(function (Builder $builder) use ($filters) {
            $search = $filters['search'];
            if (! empty($search)) {
                $builder->orWhere('name', 'LIKE', '%'.$search.'%');
            }
        });
        return $sizes->paginate(perPage: $filters['perPage'], page: $filters['page']);
    }

    public function findById(string $id): ?Size
    {
        // TODO: Implement findById() method.
    }

    public function create(array $data): Size
    {
        // TODO: Implement create() method.
    }

    public function update(string $id, array $data): Size
    {
        // TODO: Implement update() method.
    }

    public function delete(string $id): bool
    {
        // TODO: Implement delete() method.
    }
}
