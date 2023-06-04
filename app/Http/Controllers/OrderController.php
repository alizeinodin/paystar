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
        if ($request->get('status') === '1') {
            $order = Order::where(['ref_num' => $request->get('ref_num')])->first();

            // check card number
            $card = explode('******', $request->get('card_number'));

            if (
                $card[0] !== substr($order->creditCard->card_number, 0, 6)
                or
                $card[1] !== substr($order->creditCard->card_number, 12, 16)
            ) {
                $response = [
                    'message' => "عملیات با شکست مواجه شد. پرداخت باید با کارتی که انتخاب کردید انجام شود. مبلغ پرداختی تا 72 ساعت آینده به حساب شما باز خواهد گشت."
                ];
                return response()
                    ->redirectTo("/pay/error");
            }

            // verify request to bank
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
        return response()
            ->redirectTo("/pay/error");
    }
}
