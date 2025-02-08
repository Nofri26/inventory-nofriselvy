<?php

namespace App\Services;

use App\Models\Size;
use App\Repositories\SizeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SizeService
{
    public function __construct(protected SizeRepository $sizeRepository) {}

    public function findAll(): Collection
    {
        return $this->sizeRepository->findAll();
    }

    public function getAllPaginatedSizes(array $filters): LengthAwarePaginator
    {
        $filters['search']  ??= null;
        $filters['perPage'] ??= 10;
        $filters['page']    ??= 1;

        return $this->sizeRepository->getAllPaginated($filters);
    }

    public function create(array $data): Size
    {
        return $this->sizeRepository->create($data);
    }

    public function update(Size $size, array $data): Size
    {
        return $this->sizeRepository->update($size, $data);
    }

    public function delete(Size $size): bool
    {
        return $this->sizeRepository->delete($size);
    }
}
