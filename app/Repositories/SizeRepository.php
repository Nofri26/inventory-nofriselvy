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
        $sizes = $this->size->newQuery()->where(function(Builder $builder) use ($filters) {
            $search = $filters['search'];
            if (! empty($search)) {
                $builder->orWhere('name', 'LIKE', "%$search%");
            }
        });

        return $sizes->paginate(perPage: $filters['perPage'], page: $filters['page']);
    }

    public function create(array $data): Size
    {
        return $this->size->newQuery()->create($data);
    }

    public function update(Size $size, array $data): Size
    {
        $size->update($data);

        return $size;
    }

    public function delete(Size $size): bool
    {
        return $size->delete();
    }
}
