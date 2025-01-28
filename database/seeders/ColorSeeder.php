<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 20; $i++) {
            Color::query()->create([
                'name'     => 'Col' . $i,
                'hex_code' => '#Color' . $i,
            ]);
        }
    }
}
