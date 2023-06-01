<?php

namespace Tests\Unit;

use App\Models\CreditCard;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreditCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_credit_card_belongs_to_a_user(): void
    {
        $user = User::factory()->create();
        $credit_card = CreditCard::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(User::class, $credit_card->user);
    }

    public function test_a_credit_card_has_many_orders()
    {
        $user = User::factory()->create();
        $credit_card = CreditCard::factory()->create([
            'user_id' => $user->id
        ]);
        $order = Order::factory()->count(2)->create([
            'credit_card_id' => $credit_card->id,
        ]);

        $this->assertInstanceOf(Order::class, $credit_card->orders[0]);
    }
}
