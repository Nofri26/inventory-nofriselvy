<?php

namespace App\Services;

use App\Repositories\SizeRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class SizeService
{
    public function __construct(protected SizeRepository $repository) {}

    public function findAll(array $filters): LengthAwarePaginator
    {
        $filters['search'] = $filters['search'] ?? null;
        $filters['perPage'] = $filters['perPage'] ?? 10;
        $filters['page'] = $filters['page'] ?? 1;

        return $this->repository->findAll($filters);
    }
}
