<?php

namespace Tests\Unit;

use App\Models\CreditCard;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_order_belongs_to_a_credit_card()
    {
        $user = User::factory()->create();

        $credit_card = CreditCard::factory()->create([
            'user_id' => $user->id,
        ]);

        $order = Order::factory()->create([
            'credit_card_id' => $credit_card->id
        ]);

        $this->assertInstanceOf(CreditCard::class, $order->creditCard);
    }
}
