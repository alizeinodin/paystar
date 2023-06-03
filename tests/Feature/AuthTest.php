<?php

namespace Tests\Feature;

use App\Traits\WithTester;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use WithTester;
    use WithTester;

    /**
     * test register user
     *
     * @return void
     */
    public function test_register()
    {
        $req = [
            'name' => 'name',
            'email' => fake()->unique()->email(),
            'password' => '11111111'
        ];
        $response = $this->postJson(route('auth.register', $req));


        $response->assertStatus(201);
    }

    public function test_login()
    {
        $email = fake()->unique()->email();
        $req = [
            'name' => 'name',
            'email' => $email,
            'password' => '11111111'
        ];
        $response = $this->postJson(route('auth.register', $req));


        $response->assertStatus(201);

        $req = [
            'email' => $email,
            'password' => '11111111',
        ];

        $response = $this->postJson(route('auth.login', $req));
        $response->assertOk();
    }

    public function test_logout()
    {
        Sanctum::actingAs(
            $this->getUser()
        );
        $this->assertAuthenticated();
        $response = $this->postJson(route('auth.logout'));
        $response->assertStatus(204);
    }

    public function test_is_user_logged_in_failed_if_user_not_login()
    {
        $response = $this->getJson(route('auth.user'));
        $response->assertStatus(401);
    }

    public function test_getUser()
    {
        $user = $this->getUser();

        Sanctum::actingAs(
            $user
        );

        $response = $this->getJson(route('auth.user'));
        $response->assertOk();
    }
}
