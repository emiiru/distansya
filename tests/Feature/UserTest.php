<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_if_register_work()
    {
        $user = [
            'email' => 'testemails@test.com',
            'password' => 'passwordtest'
        ];

        $response = $this->postJson('/api/register', $user);
 
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User successfully registered'
            ]);
    }

    public function test_failed_register()
    {
        $user = [
            'email' => 'testemails@test.com',
            'password' => 'passwordtest'
        ];
      
        $response = $this->postJson('/api/register', $user);
 
        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Email already taken'
            ]);
    }

    public function test_user_login_passed()
    {
        $user = [
            'email' => 'testemails@test.com',
            'password' => 'passwordtest'
        ];
        $response = $this->postJson('/api/login', $user);
        $response->assertStatus(201);
    }

    public function test_user_login_failed()
    {
        $user = [
            'email' => 'testemail@test.com',
            'password' => 'passwordtest2'
        ];
        $response = $this->postJson('/api/login', $user);
        $response->assertStatus(401);
    }

    //use RefreshDatabase;
}
