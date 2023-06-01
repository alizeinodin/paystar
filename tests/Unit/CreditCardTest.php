<?php

namespace Tests\Unit;

use App\Models\CreditCard;
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
}
