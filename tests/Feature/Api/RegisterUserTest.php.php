<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFailedRegisterUser()
    {
        // When the Parameter is null, response this errorMessages.
        $this->json('POST', 'api/RegisterUser')
            ->assertStatus(401)
            ->assertJson([
                "message" => "Bad Request...",
                "errors" => [
                    'address' => ["The email field is required."],
                    'password' => ["The password field is required."],
                    'age' => ["The age filed is required."],
                    'sex' => ["The sex filed is required."],
                ]
            ]);

        // Success registerUser at here.
        $this->json('POST', 'api/RegisterUser')
            ->assertStatus(201)
            ->assertJson([
                "message" => "User was created successfully",
            ]);

    }
}
