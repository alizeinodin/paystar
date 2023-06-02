<?php

namespace Tests\Feature;

use Tests\TestCase;

class CreditCardTest extends TestCase
{
    public function test_dont_allowed_as_a_guest()
    {
        $response = $this->getJson(route('card.all'));
        $response->assertStatus(401);
    }
}
