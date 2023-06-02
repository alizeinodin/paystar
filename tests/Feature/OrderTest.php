<?php

namespace Tests\Feature;

use App\Models\CreditCard;
use App\Models\Product;
use App\Traits\WithTester;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use WithTester;

    public function test_dont_allowed_as_a_guest()
    {
        $response = $this->postJson(route('order.buy', ['product' => 1]));
        $response->assertStatus(401);
    }

    public function test_buy_a_product_and_place_an_order()
    {
        $user = $this->getUser();
        Sanctum::actingAs($user);

        $product = Product::factory()->create();

        $creditCard = CreditCard::factory()->create([
            'user_id' => $user->id
        ]);

        $request = [
            'card_id' => $creditCard->id,
        ];

        $response = $this->postJson(route('order.buy', ['product' => $product->id]), $request);
        $response->assertCreated();
    }
}
