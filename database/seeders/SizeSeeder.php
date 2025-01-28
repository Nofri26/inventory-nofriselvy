<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Size::query()->create([
                'name'        => 'S' . $i,
                'age_from'    => $i - 1,
                'age_to'      => $i,
                'description' => 'Size #' . $i,
            ]);
        }
    }
}
