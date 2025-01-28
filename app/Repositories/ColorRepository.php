<?php

namespace App\Repositories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ColorRepository implements ColorRepositoryInterface
{
    public function __construct(protected Color $color) {}

    public function findAllColor(array $filters): LengthAwarePaginator
    {
        $colors = $this->color->newQuery()->where(function(Builder $builder) use ($filters) {
            $search = $filters['search'] ?? null;
            if (! empty($search)) {
                $builder->orWhere('name', 'like', "%$search%")
                    ->orWhere('hex_code', 'like', "%$search%");
            }
        });

        return $colors->paginate(perPage: $filters['perPage'], page: $filters['page']);
    }

    public function createColor(array $data): Color
    {
        return $this->color->newQuery()->create($data);
    }

    public function updateColor(Color $color, array $data): Color
    {
        $color->update($data);

        return $color;
    }

    public function deleteColor(Color $color): bool
    {
        return $color->delete();
    }
}
