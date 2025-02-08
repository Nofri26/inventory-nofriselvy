<?php

namespace Tests\Feature;

use App\Http\Controllers\ApiResponse;
use App\Models\Color;
use App\Models\User;
use Database\Seeders\ColorSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ColorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([UserSeeder::class, ColorSeeder::class]);
        $user = User::query()->first();

        $this->actingAs($user);
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function test_get_all_data()
    {
        $response = $this->get(route('colors.get'))
            ->assertStatus(200)
            ->json();

        self::assertCount(20, $response['data']);
    }

    public function test_index_search()
    {
        $response = $this->get(route('colors.index', [
            'search' => 'Col11',
        ]))->assertStatus(200)
            ->json();

        self::assertEquals(1, $response['meta']['totalData']);
    }

    public function test_index_per_page()
    {
        $response = $this->get(route('colors.index', [
            'perPage' => 20,
        ]))->assertStatus(200)
            ->json();

        self::assertEquals(20, $response['meta']['perPage']);
    }

    public function test_index_page()
    {
        $response = $this->get(route('colors.index', [
            'page' => 2,
        ]))->assertStatus(200)
            ->json();

        self::assertEquals(2, $response['meta']['page']);
    }

    public function test_create_success()
    {
        $this->post(route('colors.store'), [
            'name'     => 'Color Test',
            'hex_code' => '#000000',
        ])->assertStatus(201)
            ->assertJson([
                'message' => ApiResponse::RESPONSE_GET,
                'data'    => [
                    'name'     => 'Color Test',
                    'hex_code' => '#000000',
                ],
            ]);
    }

    public function test_create_failed()
    {
        $this->post(route('colors.store'), [
            'name'     => '',
            'hex_code' => '',
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'The name field is required. (and 1 more error)',
                'errors'  => [
                    'name'     => ['The name field is required.'],
                    'hex_code' => ['The hex code field is required.'],
                ],
            ]);
    }

    public function test_show_success()
    {
        $color = Color::query()->first();
        $this->get(route('colors.show', $color))
            ->assertStatus(200)
            ->assertExactJson([
                'message' => ApiResponse::RESPONSE_GET,
                'data'    => [
                    'id'         => $color->id,
                    'name'       => $color->name,
                    'hex_code'   => $color->hex_code,
                    'created_at' => $color->created_at,
                    'updated_at' => $color->updated_at,
                ],
            ]);
    }

    public function test_show_not_found()
    {
        $this->get(route('colors.show', 1))
            ->assertStatus(404);
    }

    public function test_update_success()
    {
        $color = Color::query()->first();
        $this->put(route('colors.update', $color), [
            'name'     => 'Color Test Update',
            'hex_code' => '#000001',
        ])->assertStatus(200)
            ->assertJson([
                'message' => ApiResponse::RESPONSE_UPDATE,
                'data'    => [
                    'name'     => 'Color Test Update',
                    'hex_code' => '#000001',
                ],
            ]);
    }

    public function test_update_failed()
    {
        $color = Color::query()->first();
        $this->put(route('colors.update', $color), [
            'name'     => '',
            'hex_code' => '',
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'The name field is required. (and 1 more error)',
                'errors'  => [
                    'name'     => ['The name field is required.'],
                    'hex_code' => ['The hex code field is required.'],
                ],
            ]);
    }

    public function test_destroy()
    {
        $color = Color::query()->first();
        $this->delete(route('colors.destroy', $color))
            ->assertStatus(200);
    }
}
