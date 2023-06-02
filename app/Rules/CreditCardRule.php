<?php

namespace App\Rules;

use App\Models\CreditCard;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreditCardRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $credit_card = CreditCard::find($value);

        if ($credit_card->user_id !== auth()->user()->id) {
            $fail('The :attribute must be for own user');
        }
    }
}
