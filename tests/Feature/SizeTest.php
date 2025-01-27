<?php

namespace Tests\Feature;

use App\Http\Controllers\ApiResponse;
use App\Models\User;
use Database\Seeders\SizeSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_success()
    {
        $this
            ->post(route('sizes.store'), [
                'name'        => '21',
                'description' => '7 - 8 Tahun',
            ])->assertStatus(201)
            ->assertJson([
                'message' => ApiResponse::RESPONSE_CREATE,
                'data'    => [
                    'name'        => '21',
                    'description' => '7 - 8 Tahun',
                ],
            ]);
    }

    public function test_create_failed()
    {
        $this
            ->post(route('sizes.store'), [
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
        $this->seed([SizeSeeder::class]);
        $response = $this
            ->get('/api/sizes?search=S')->assertStatus(200)
            ->json();

        self::assertEquals(20, $response['meta']['totalData']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([UserSeeder::class]);
        $user = User::query()->first();

        $this->actingAs($user);
        $this->withHeaders([
            'Accept' => 'application/json',
        ]);
    }
}
