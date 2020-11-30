<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class UsersTest extends TestCase
{
    private $users;

    protected function setUp(): void
    {
        parent::setUp();

        $this->users = User::all();
    }

    /**
     * @test
     */
    public function indexReturnListOfUsers()
    {
        $response = $this->json('GET', '/api/users');

        $response->assertStatus(200)->assertJson(['users' => []]);
    }

    /**
     * @test
     */
    public function showReturnSingleUser()
    {
        $user     = $this->users->random();
        $response = $this->json('GET', "/api/users/{$user->id}");

        $response->assertStatus(200)->assertJson(['user' => []]);
    }

    /**
     * @test
     */
    public function showReturnNotFound()
    {
        $userId   = 9001;
        $response = $this->json('GET', "/api/users/{$userId}");

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function storeShouldCreateNewUser()
    {
        $factory    = Factory::create();
        $first_name = $factory->firstName;
        $last_name  = $factory->lastName;
        $email      = $factory->email;
        $password   = $factory->password(8);
        $data       = compact('first_name', 'last_name', 'email', 'password');
        $response   = $this->json('POST', '/api/users', $data);

        $response->assertStatus(201)->assertJson(['user' => []]);

        $this->assertDatabaseHas('users', Arr::except($data, ['password']));
    }

    /**
     * @test
     */
    public function storeShouldReturnUnprocessableEntity()
    {
        $data     = [];
        $response = $this->json('POST', '/api/users', $data);

        $response->assertStatus(400);
    }
}
