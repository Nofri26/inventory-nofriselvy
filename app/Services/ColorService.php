<?php

namespace App\Services;

use App\Models\Color;
use App\Repositories\ColorRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ColorService
{
    public function __construct(protected ColorRepository $colorRepository) {}

    public function findAllColor(array $filters): LengthAwarePaginator
    {
        $filters['search']  ??= null;
        $filters['perPage'] ??= 10;
        $filters['page']    ??= 1;

        return $this->colorRepository->findAllColor($filters);
    }

    public function createColor(array $data): Color
    {
        return $this->colorRepository->createColor($data);
    }

    public function updateColor(Color $color, array $data): Color
    {
        return $this->colorRepository->updateColor($color, $data);
    }

    public function deleteColor(Color $color): bool
    {
        return $this->colorRepository->deleteColor($color);
    }
}
