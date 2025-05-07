<?php

namespace Tests\Feature\Api;

use App\Models\Api\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function testFailedLogin ()
    {
        Admin::create([
            'nick_name' => 'test1234',
            'address'=>'test1234@com',
            'password' => bcrypt('secret123$'),
            'age' => '30',
            'sex' => '1'
        ]);

        $data = [
            'email' => '',
            'password' => 'secret123$',
        ];

        //attempt login
        $response = $this->json('POST', redirect('http://127.0.0.1:8000/api/login'), $data);
        //Assert it was successful and a token was received
        $response->assertStatus(404);
    }

//    public function testLoginSuccess()
//    {
//        // When the Parameter is null, response this errorMessages.
//        $response = $this->postJson('/api/login', ['email' => ''], ['password' => Hash::make('test1234')]);
//        $response
//            ->assertStatus(401)
//            ->assertJson([
//                'created' => false,
//            ]);
//    }
}
