<?php

namespace App\Repositories;

use App\Models\Size;
use Illuminate\Pagination\LengthAwarePaginator;

interface SizeRepositoryInterface
{
    public function findAll(array $filters): LengthAwarePaginator;

    public function findById(string $id): ?Size;

    public function create(array $data): Size;

    public function update(string $id, array $data): Size;

    public function delete(string $id): bool;
}
