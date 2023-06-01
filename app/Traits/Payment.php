<?php

namespace App\Traits;

use GuzzleHttp\Client;

/*
 * The Payment Trait is for Connection with PayStar
 */

trait Payment
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('PAYSTAR_BASE_URL'),
            'timeout' => 2.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . env('PAYSTAR_GATEWAY_ID')
            ],
        ]);
    }

}
