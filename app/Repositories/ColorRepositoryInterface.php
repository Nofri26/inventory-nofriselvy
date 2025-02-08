<?php

namespace App\Repositories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ColorRepositoryInterface
{
    public function findAll(): Collection;

    public function getAllPaginated(array $filters): LengthAwarePaginator;

    public function create(array $data): Color;

    public function update(Color $color, array $data): Color;

    public function delete(Color $color): bool;
}
