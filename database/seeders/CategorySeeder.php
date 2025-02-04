<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Category::query()->create([
                'name'        => 'C' . $i,
                'description' => 'Category #' . $i,
            ]);
        }
    }
}
