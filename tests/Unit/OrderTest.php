<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_order_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(User::class, $order->user);
    }
}
