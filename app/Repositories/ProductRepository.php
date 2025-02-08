<?php

namespace App\Repositories;

use App\Filters\ProductFilters;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected Product $product) {}

    public function getAllPaginated(array $filters): LengthAwarePaginator
    {
        $products = $this->product->newQuery()
            ->with('productVariants', 'productVariants.size', 'productVariants.color', 'productVariants.category');

        if ($filters) {
            $products = (new ProductFilters($products, $filters))->apply();
        }

        return $products->paginate(perPage: $filters['perPage'], page: $filters['page']);
    }

    public function create(array $data): Product
    {
        // TODO: Implement create() method.
    }

    public function update(Product $product, array $data): Product
    {
        // TODO: Implement update() method.
    }

    public function delete(Product $product): bool
    {
        // TODO: Implement delete() method.
    }
}
