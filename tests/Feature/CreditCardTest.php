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

    /**
     * @throws \Exception
     */
    private function getCardNumber(): string
    {
        return (string) random_int(1000000000000000, 9999999999999999);
    }

    public function test_dont_allowed_as_a_guest()
    {
        $response = $this->getJson(route('card.all'));
        $response->assertStatus(401);
    }

    /**
     * @throws \Exception
     */
    public function test_store_a_credit_card()
    {
        $user = $this->getUser();
        Sanctum::actingAs($user);

        $cardNumber = $this->getCardNumber();

        $request = [
            'card_number' => $cardNumber,
        ];

        $response = $this->postJson(route('card.store'), $request);
        $response->assertCreated();
    }

    /**
     * @throws \Throwable
     */
    public function test_get_all_cards_of_user()
    {
        $user = $this->getUser();
        Sanctum::actingAs($user);

        $items = 5;

        for ($i = 0; $i < $items; $i++) {
            $cardNumber = $this->getCardNumber();

            $request = [
                'card_number' => $cardNumber,
            ];

            $response = $this->postJson(route('card.store'), $request);
            $response->assertCreated();
        }

        $response = $this->getJson(route('card.all'));
        $response->assertOk();
    }
}
