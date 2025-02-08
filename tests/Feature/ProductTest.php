<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ColorSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\SizeSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertCount;

use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([UserSeeder::class, SizeSeeder::class, CategorySeeder::class, ColorSeeder::class, ProductSeeder::class]);
        $user = User::query()->first();

        $this->actingAs($user);
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function test_index_search()
    {
        $response = $this->get(route('products.index', [
            'search' => 'Product 1',
        ]))->assertStatus(200)
            ->json();

        assertCount(2, $response['data']);
    }

    public function test_index_filter_is_out_of_stock()
    {
        $response = $this->get(route('products.index', [
            'isOutOfStock' => true,
        ]));

        $response->assertStatus(200);
    }

    public function test_index_filter_min_price()
    {
        $response = $this->get(route('products.index', [
            'minPrice' => 20000,
        ]));

        $response->assertStatus(200);
    }
}
