<?php

namespace App\Services;

use App\Models\Color;
use App\Repositories\ColorRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ColorService
{
    public function __construct(protected ColorRepository $colorRepository) {}

    public function findAll(): Collection
    {
        return $this->colorRepository->findAll();
    }

    public function getAllPaginatedColors(array $filters): LengthAwarePaginator
    {
        $filters['search']  ??= null;
        $filters['perPage'] ??= 10;
        $filters['page']    ??= 1;

        return $this->colorRepository->getAllPaginated($filters);
    }

    public function createColor(array $data): Color
    {
        return $this->colorRepository->create($data);
    }

    public function updateColor(Color $color, array $data): Color
    {
        return $this->colorRepository->update($color, $data);
    }

    public function deleteColor(Color $color): bool
    {
        return $this->colorRepository->delete($color);
    }
}
