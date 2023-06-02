<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;

class CreditCardController extends Controller
{
    /**
     * @return mixed
     */
    public function index(): mixed
    {
        return CreditCard::where(['user_id' => auth('api')->user()->id])->get();
    }
}
