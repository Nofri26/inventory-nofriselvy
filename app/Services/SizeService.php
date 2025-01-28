<?php

namespace App\Services;

use App\Models\Size;
use App\Repositories\SizeRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class SizeService
{
    public function __construct(protected SizeRepository $repository) {}

    public function findAll(array $filters): LengthAwarePaginator
    {
        $filters['search']  ??= null;
        $filters['perPage'] ??= 10;
        $filters['page']    ??= 1;

        return $this->repository->findAll($filters);
    }

    public function create(array $data): Size
    {
        return $this->repository->create($data);
    }

    public function update(Size $size, array $data): Size
    {
        return $this->repository->update($size, $data);
    }

    public function delete(Size $size): bool
    {
        return $this->repository->delete($size);
    }
}
