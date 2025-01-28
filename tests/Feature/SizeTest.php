<?php

namespace Tests\Feature;

use App\Http\Controllers\ApiResponse;
use App\Models\Size;
use App\Models\User;
use Database\Seeders\SizeSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SizeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([UserSeeder::class, SizeSeeder::class]);
        $user = User::query()->first();

        $this->actingAs($user);
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }

    public function test_create_success()
    {
        $this
            ->post(route('sizes.store'), [
                'name'        => '21',
                'age_from'    => 0,
                'age_to'      => 1,
                'description' => '7 - 8 Tahun',
            ])->assertStatus(201)
            ->assertJson([
                'message' => ApiResponse::RESPONSE_CREATE,
                'data'    => [
                    'name'        => '21',
                    'age_from'    => 0,
                    'age_to'      => 1,
                    'description' => '7 - 8 Tahun',
                ],
            ]);
    }

    public function test_create_failed()
    {
        $this
            ->post(route('sizes.store'), [
                'name'     => '',
                'age_from' => '',
                'age_to'   => '',
            ])->assertStatus(422)
            ->assertJson([
                'message' => 'The name field is required. (and 2 more errors)',
                'errors'  => [
                    'name'     => ['The name field is required.'],
                    'age_from' => ['The age from field is required.'],
                    'age_to'   => ['The age to field is required.'],
                ],
            ]);
    }

    public function test_index_search()
    {
        $response = $this
            ->get(route('sizes.index'), [
                'search' => 'S',
            ])->assertStatus(200)
            ->json();

        self::assertEquals(20, $response['meta']['totalData']);
    }

    public function test_show_success()
    {
        $size = Size::query()->first();
        $this
            ->get(route('sizes.show', [
                'size' => $size,
            ]))->assertStatus(200)
            ->assertExactJson([
                'message' => ApiResponse::RESPONSE_GET,
                'data'    => [
                    'id'          => $size->id,
                    'name'        => $size->name,
                    'age_from'    => $size->age_from,
                    'age_to'      => $size->age_to,
                    'description' => $size->description,
                    'created_at'  => $size->created_at,
                    'updated_at'  => $size->updated_at,
                ],
            ]);
    }

    public function test_show_now_found()
    {
        $this->get(route('sizes.show', [
            'size' => '1',
        ]))->assertStatus(404);
    }

    public function test_update_success()
    {
        $size = Size::query()->first();

        $this
            ->put(route('sizes.update', $size), [
                'name'        => 'Updated Name',
                'age_from'    => 1,
                'age_to'      => 2,
                'description' => 'Updated Description',
            ])->assertStatus(200)
            ->assertJson([
                'message' => ApiResponse::RESPONSE_UPDATE,
                'data'    => [
                    'id'          => $size->id,
                    'name'        => 'Updated Name',
                    'age_from'    => 1,
                    'age_to'      => 2,
                    'description' => 'Updated Description',
                ],
            ]);

        $this->assertDatabaseHas('sizes', [
            'id'          => $size->id,
            'name'        => 'Updated Name',
            'description' => 'Updated Description',
        ]);
    }

    public function test_update_failed()
    {
        $size = Size::query()->first();
        $this
            ->put(route('sizes.update', $size), [
                'name'     => '',
                'age_from' => '',
                'age_to'   => '',
            ])->assertStatus(422)
            ->assertJson([
                'message' => 'The name field is required. (and 2 more errors)',
                'errors'  => [
                    'name'     => ['The name field is required.'],
                    'age_from' => ['The age from field is required.'],
                    'age_to'   => ['The age to field is required.'],
                ],
            ]);
    }

    public function test_delete()
    {
        $size = Size::query()->first();
        $this
            ->delete(route('sizes.destroy', $size))
            ->assertStatus(200)
            ->assertExactJson([
                'message' => ApiResponse::RESPONSE_DELETE,
                'data'    => null,
            ]);
    }
}
