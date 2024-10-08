<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_register_success()
    {
        $this->post("/api/users", [
            "email" => "albab@gmail.com",
            "password" => "12345678"
        ])->assertStatus(201)->assertJson([
                    "data" => [
                        "email" => "albab@gmail.com",

                    ]
                ]);
    }
    public function test_login_success(){
        $this->post("/api/user/login", [
            "email"=> "albabriziq123@gmail.com",
            "password"=> "12345678"
        ])->assertStatus(200)->assertJson([
            "email"=> "albabriziq123@gmail.com", 
        ]);
    }
}
