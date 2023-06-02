<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreditCardTest extends TestCase
{
    use WithFaker;

    private function getUser()
    {
        return User::factory()->create();
    }

    public function test_dont_allowed_as_a_guest()
    {
        $response = $this->getJson(route('card.all'));
        $response->assertStatus(401);
    }

    public function test_store_a_credit_card()
    {
        $user = $this->getUser();
        Sanctum::actingAs($user);

        $cardNumber = $this->faker->creditCardNumber;

        $request = [
            'card_number' => $cardNumber,
        ];

        $response = $this->postJson(route('card.store'), $request);
        $response->assertCreated();
    }
}
