<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId     = User::query()->inRandomOrder()->value('id');
        $sizeId     = Size::query()->inRandomOrder()->value('id');
        $colorId    = Color::query()->inRandomOrder()->value('id');
        $categoryId = Category::query()->inRandomOrder()->value('id');
        for ($i = 1; $i <= 10; $i++) {
            $product = Product::query()->create([
                'name'          => 'Product ' . $i,
                'description'   => 'Product description ' . $i,
                'created_by_id' => $userId,
            ]);
            for ($j = 1; $j <= 2; $j++) {
                ProductVariant::query()->create([
                    'sku'         => 'Product ' . $i . $j,
                    'stock'       => rand(1, 10),
                    'price'       => rand(10000, 100000),
                    'product_id'  => $product->id,
                    'size_id'     => $sizeId,
                    'color_id'    => $colorId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
