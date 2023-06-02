<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\Order\BuyRequest;
use App\Models\Order;
use App\Models\Product;
use App\Traits\Payment;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse|void
     * @throws GuzzleException
     */
    public function callback(Request $request)
    {
        if ($request['status'] === 1) {
            $order = Order::where(['ref_num' => $request['ref_num']])->first();

            if ($request['card_number'] !== $order->creditCard->card_number) {
                $response = [
                    'message' => "عملیات با شکست مواجه شد. پرداخت باید با کارتی که انتخاب کردید انجام شود. مبلغ پرداختی تا 72 ساعت آینده به حساب شما باز خواهد گشت."
                ];
                return response()->json($response, Response::HTTP_PAYMENT_REQUIRED);
            }

            $response = $this->verify($order['amount'],
                $order['ref_num'],
                $request['card_number'],
                $request['tracking_code']);

            if ($response['status'] !== 1) {
                return response()
                    ->json($response, Response::HTTP_FORBIDDEN);
            }

            $order->update([
                'transaction_id' => $request['transaction_id'],
                'tracking_code' => $request['tracking_code'],
                'status' => OrderStatus::ACCEPTED
            ]);

            return response()
                ->json($response, Response::HTTP_ACCEPTED);
        }
        # TODO implementation error handling
    }
}
