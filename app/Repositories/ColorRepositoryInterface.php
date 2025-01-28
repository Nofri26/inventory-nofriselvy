<?php

namespace App\Repositories;

use App\Models\Color;
use Illuminate\Pagination\LengthAwarePaginator;

interface ColorRepositoryInterface
{
    public function findAllColor(array $filters): LengthAwarePaginator;

    public function createColor(array $data): Color;

    public function updateColor(Color $color, array $data): Color;

    public function deleteColor(Color $color): bool;
}
