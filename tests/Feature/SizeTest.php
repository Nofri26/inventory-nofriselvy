<?php

namespace Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class SizeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([UserSeeder::class]);

        $user = User::query()->first();
        $this->actingAs($user);
    }

    public function test_index_search()
    {
        $this->get(route('sizes.index'), [
            'search' => 'test',
        ])->assertStatus(200);
    }
}
