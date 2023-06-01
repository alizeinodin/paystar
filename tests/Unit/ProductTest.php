<?php

namespace Tests\Unit;

use App\Models\CreditCard;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_belongs_to_many_orders()
    {
        $user = User::factory()->create();

        $credit_card = CreditCard::factory()->create([
            'user_id' => $user->id,
        ]);

        $order = Order::factory()->create([
            'credit_card_id' => $credit_card->id
        ]);

        $product_one = Product::factory()->create();
        $product_two = Product::factory()->create();

        $order->products()->attach($product_one);
        $order->products()->attach($product_two);

        $this->assertInstanceOf(Order::class, $product_one->orders[0]);

        $this->assertDatabaseHas('orders_products', [
            'order_id' => $order->id,
            'product_id' => $product_one->id,
        ]);

        $this->assertDatabaseHas('orders_products', [
            'order_id' => $order->id,
            'product_id' => $product_two->id,
        ]);
    }
}
