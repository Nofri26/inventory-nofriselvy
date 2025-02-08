<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProductFilters
{
    public function __construct(
        protected Builder $builder,
        protected array $filters
    ) {}

    public function apply(): Builder
    {
        foreach ($this->filters as $key => $value) {
            if (method_exists($this, $key)) {
                if ($value === false) {
                    return $this->builder;
                } else {
                    return $this->$key($value);
                }
            }
        }

        return $this->builder;
    }

    protected function search($value): Builder
    {
        return $this->builder->where(function(Builder $builder) use ($value) {
            $searchTerm = '%' . $value . '%';

            return $builder->where('name', 'LIKE', $searchTerm)
                ->orWhere('description', 'LIKE', $searchTerm);
        });
    }

    protected function isOutOfStock($value): Builder
    {
        return $this->builder->whereHas('productVariants', function($query) use ($value) {
            if ($value) {
                $query->where('product_variants.stock', '=', 0);
            } else {
                $query->where('product_variants.stock', '>', 0);
            }
        });
    }

    protected function minPrice($value): Builder
    {
        return $this->builder->whereHas('productVariants', function(Builder $builder) use ($value) {
            return $builder->where('product_variants.price', '>=', $value);
        });
    }

    protected function maxPrice($value): Builder
    {
        return $this->builder->whereHas('productVariants', function(Builder $builder) use ($value) {
            return $builder->where('product_variants.price', '<=', $value);
        });
    }

    protected function size_id($value): Builder
    {
        return $this->builder->whereHas('productVariants.size', function(Builder $builder) use ($value) {
            return $builder->whereIn('sizes.id', (array) $value);
        });
    }

    protected function color_id($value): Builder
    {
        return $this->builder->whereHas('productVariants.color', function(Builder $builder) use ($value) {
            return $builder->whereIn('colors.id', (array) $value);
        });
    }

    protected function category_id($value): Builder
    {
        return $this->builder->whereHas('productVariants.category', function(Builder $builder) use ($value) {
            return $builder->whereIn('categories.id', (array) $value);
        });
    }
}
