<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\BuyRequest;
use App\Models\Order;
use App\Models\Product;
use App\Traits\Payment;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use Payment;

    public function buy(BuyRequest $request, Product $product): JsonResponse
    {
        $validated_data = $request->validated();

        // create an order
        $order = Order::create([
            'amount' => $product->price,
            'credit_card_id' => $validated_data['card_id'],
        ]);

        $order->products()->attach($product);

        $response = $this->create($order->amount, $order->id);

        if ($response['status'] === 1) {
            $order->update([
                'amount' => $response['payment_amount'],
                'ref_num' => $response['ref_num'],
            ]);
        }
        return response()->json($response);
    }
}
