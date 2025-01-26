<?php

namespace Tests\Feature\Auth;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success()
    {
        $this->postJson(route('user.register'), [
            'first_name' => 'Admin',
            'last_name' => 'Test',
            'username' => 'admintest',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertStatus(201)
            ->assertJson([
                'message' => 'User register successfully.',
                'data' => [
                    'first_name' => 'Admin',
                    'last_name' => 'Test',
                    'username' => 'admintest',
                ],
            ]);
    }

    public function test_login_success()
    {
        $this->seed([UserSeeder::class]);
        $this->postJson(route('user.login'), [
            'username' => 'admintest',
            'password' => 'password',
        ])->assertStatus(200)
            ->assertJson([
                'message' => 'User login successfully.',
                'data' => [
                    'first_name' => 'Admin',
                    'last_name' => 'Test',
                    'username' => 'admintest',
                ],
            ]);
        $token = DB::table('personal_access_tokens')
            ->where('name', 'admintest')
            ->first();
        $this->assertNotNull($token);
    }

    public function test_login_failed_username_not_found()
    {
        $this->seed([UserSeeder::class]);
        $this->postJson(route('user.login'), [
            'username' => 'admintest',
            'password' => 'admintest',
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'Invalid username or password.',
                'errors' => [
                    'username' => ['Invalid username or password.'],
                ],
            ]);
    }
}
