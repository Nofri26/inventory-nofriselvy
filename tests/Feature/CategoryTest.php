<?php

namespace Tests\Feature;

use App\Http\Controllers\ApiResponse;
use App\Models\Category;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([UserSeeder::class, CategorySeeder::class]);
        $user = User::query()->first();

        $this->actingAs($user);
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function test_create_success()
    {
        $this
            ->post(route('categories.store'), [
                'name'        => 'Test Category',
                'description' => 'Test Category description',
            ])->assertStatus(201)
            ->assertJson([
                'message' => ApiResponse::RESPONSE_CREATE,
                'data'    => [
                    'name'        => 'Test Category',
                    'description' => 'Test Category description',
                ],
            ]);
    }

    public function test_create_failed()
    {
        $this->post(route('categories.store'), [
            'name' => '',
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'The name field is required.',
                'errors'  => [
                    'name' => ['The name field is required.'],
                ],
            ]);
    }

    public function test_index_search()
    {
        $response = $this->get(route('categories.index'), [
            'search' => 'C',
        ])->assertStatus(200)
            ->json();

        self::assertEquals(20, $response['meta']['totalData']);
    }

    public function test_show_success()
    {
        $category = Category::query()->first();
        $this->get(route('categories.show', $category))
            ->assertStatus(200)
            ->assertExactJson([
                'message' => ApiResponse::RESPONSE_GET,
                'data'    => [
                    'id'          => $category->id,
                    'name'        => $category->name,
                    'description' => $category->description,
                    'created_at'  => $category->created_at,
                    'updated_at'  => $category->updated_at,
                ],
            ]);
    }

    public function test_show_not_found()
    {
        $this->put(route('categories.show', 1), [
            'name' => '',
        ])->assertStatus(404);
    }

    public function test_update_success()
    {
        $category = Category::query()->first();

        $this
            ->put(route('categories.update', $category), [
                'name'        => 'Updated Name',
                'description' => 'Updated Description',
            ])->assertStatus(200)
            ->assertJson([
                'message' => ApiResponse::RESPONSE_UPDATE,
                'data'    => [
                    'id'          => $category->id,
                    'name'        => 'Updated Name',
                    'description' => 'Updated Description',
                ],
            ]);
    }

    public function test_update_failed()
    {
        $category = Category::query()->first();

        $this->put(route('categories.update', $category), [
            'name' => '',
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'The name field is required.',
                'errors'  => [
                    'name' => ['The name field is required.'],
                ],
            ]);
    }

    public function test_delete()
    {
        $size = Category::query()->first();
        $this
            ->delete(route('categories.destroy', $size))
            ->assertStatus(200)
            ->assertExactJson([
                'message' => ApiResponse::RESPONSE_DELETE,
                'data'    => null,
            ]);
    }
}
