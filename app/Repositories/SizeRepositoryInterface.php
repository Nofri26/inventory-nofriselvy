<?php

namespace App\Repositories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface SizeRepositoryInterface
{
    public function findAll(): Collection;

    public function getAllPaginated(array $filters): LengthAwarePaginator;

    public function create(array $data): Size;

    public function update(Size $size, array $data): Size;

    public function delete(Size $size): bool;
}
