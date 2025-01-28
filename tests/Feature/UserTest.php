<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_failed()
    {
        $this
            ->postJson(route('user.register'), [
                'first_name'            => '',
                'last_name'             => '',
                'username'              => '',
                'password'              => '',
                'password_confirmation' => '',
            ])->assertStatus(422)
            ->assertJson([
                'message' => 'The first name field is required. (and 3 more errors)',
                'errors'  => [
                    'first_name' => ['The first name field is required.'],
                    'last_name'  => ['The last name field is required.'],
                    'username'   => ['The username field is required.'],
                    'password'   => ['The password field is required.'],
                ],
            ]);
    }

    public function test_register_username_already_been_taken()
    {
        $this->test_register_success();
        $this
            ->postJson(route('user.register'), [
                'first_name'            => 'Admin',
                'last_name'             => 'Test',
                'username'              => 'admintest',
                'password'              => 'password',
                'password_confirmation' => 'password',
            ])->assertStatus(422)
            ->assertJson([
                'message' => 'The username has already been taken.',
                'errors'  => [
                    'username' => ['The username has already been taken.'],
                ],
            ]);
    }

    public function test_register_success()
    {
        $this
            ->postJson(route('user.register'), [
                'first_name'            => 'Admin',
                'last_name'             => 'Test',
                'username'              => 'admintest',
                'password'              => 'password',
                'password_confirmation' => 'password',
            ])->assertStatus(201)
            ->assertJson([
                'message' => 'Users register successfully.',
                'data'    => [
                    'first_name' => 'Admin',
                    'last_name'  => 'Test',
                    'username'   => 'admintest',
                ],
            ]);
    }

    public function test_login_failed_username_not_found()
    {
        $this->seed([UserSeeder::class]);
        $this
            ->postJson(route('user.login'), [
                'username' => 'admintest',
                'password' => 'admintest',
            ])->assertStatus(422)
            ->assertJson([
                'message' => 'Invalid username or password.',
                'errors'  => [
                    'username' => ['Invalid username or password.'],
                ],
            ]);
    }

    public function test_logout_success()
    {
        $this->test_login_success();
        $this
            ->deleteJson(route('user.logout'))
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Users logout successfully.',
            ]);
    }

    public function test_login_success()
    {
        $this->seed([UserSeeder::class]);
        $this
            ->postJson(route('user.login'), [
                'username' => 'admintest',
                'password' => 'password',
            ])->assertStatus(200)
            ->assertJson([
                'message' => 'Users login successfully.',
                'data'    => [
                    'first_name' => 'Admin',
                    'last_name'  => 'Test',
                    'username'   => 'admintest',
                ],
            ]);
        $token = DB::table('personal_access_tokens')
            ->where('name', 'admintest')
            ->first();
        $this->assertNotNull($token);
    }

    public function test_logout_failed()
    {
        $this
            ->deleteJson(route('user.logout'))
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}
