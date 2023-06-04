<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\BuyRequest;
use App\Models\Order;
use App\Models\Product;
use App\Traits\Payment;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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

        if ($response->status === 1) {
            $order->update([
                'amount' => $response->data->payment_amount,
                'ref_num' => $response->data->ref_num,
            ]);
        }

        $response = [
            'token' => $response->data->token,
            'amount' => $response->data->payment_amount,
        ];
        return response()->json($response, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function callback(Request $request): RedirectResponse
    {
        if ($request->get('status') === 1) {
            $order = Order::where(['ref_num' => $request->get('ref_num')])->first();

            if ($request->get('card_number') !== $order->creditCard->card_number) {
                $response = [
                    'message' => "عملیات با شکست مواجه شد. پرداخت باید با کارتی که انتخاب کردید انجام شود. مبلغ پرداختی تا 72 ساعت آینده به حساب شما باز خواهد گشت."
                ];
                return response()
                    ->redirectTo("/pay/error");
            }

            $response = $this->verify($order['amount'],
                $order['ref_num'],
                $request->get('card_number'),
                $request->get('tracking_code'));

            if ($response->status !== 1) {
                return response()
                    ->redirectTo("/pay/error");
            }

            $order->update([
                'transaction_id' => $request->get('transaction_id'),
                'tracking_code' => $request->get('tracking_code'),
                'status' => OrderStatus::ACCEPTED
            ]);

            $response = [
                'price' => $response->data->price,
                'ref_num' => $response->data->ref_num,
                'card_number' => $response->data->card_number,
            ];

            return response()
                ->redirectTo("/pay/success/{$response['price']}/{$response['ref_num']}/{$response['card_number']}");
        }
    }
}
