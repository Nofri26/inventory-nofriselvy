<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(protected ProductRepository $productRepository) {}

    public function getAllPaginatedProduct(array $filters): LengthAwarePaginator
    {
        $filters['search']       ??= null;
        $filters['perPage']      ??= 10;
        $filters['page']         ??= 1;
        $filters['isOutOfStock'] ??= false;
        $filters['maxPrice']     ??= null;
        $filters['minPrice']     ??= null;
        $filters['size_id']      ??= null;
        $filters['color_id']     ??= null;
        $filters['category_id']  ??= null;

        return $this->productRepository->getAllPaginated($filters);
    }
}
