<?php

namespace App\Traits;

use App\Models\User;

trait WithTester
{
    protected function getUser()
    {
        return User::factory()->create();
    }

    /**
     * @throws \Exception
     */
    protected function getCardNumber(): string
    {
        return (string) random_int(1000000000000000, 9999999999999999);
    }
}
