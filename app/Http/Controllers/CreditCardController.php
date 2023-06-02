<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditCard\StoreRequest;
use App\Models\CreditCard;
use Symfony\Component\HttpFoundation\Response;

class CreditCardController extends Controller
{
    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return CreditCard::where(['user_id' => auth('api')->user()->id])->get();
    }

    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        $creditCard = CreditCard::create([
            'card_number' => $validatedData['card_number'],
            'user_id' => $request->user()->id,
        ]);

        $response = [
            'message' => 'کارت بانکی با موفقیت افزوده شد',
            'creditCard' => $creditCard,
        ];

        return response()->json($response, Response::HTTP_CREATED);
    }
}
