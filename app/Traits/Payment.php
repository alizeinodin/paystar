<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\StreamInterface;

/*
 * The Payment Trait is for Connection with PayStar
 */

trait Payment
{
    private Client $client;
    private string $algorithm = "SHA512";

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

    private function sign(int $amount, int $order_id, string $callback): bool|string
    {
        $data = $amount . "#" . $order_id . "#" . $callback;
        return hash_hmac($this->algorithm, $data, env('PAYSTAR_KEY'));
    }

    /**
     * @param int $amount
     * @param int $order_id
     *
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function create(int $amount, int $order_id): StreamInterface
    {
        $body = [
            'amount' => $amount,
            'order_id' => $order_id,
            'callback' => env('paystar_callback_url'),
            'sign' => $this->sign($amount, $order_id, env('paystar_callback_url')),
        ];

        $response = $this->client->request("POST", '/create', [
            'body' => $body
        ]);

        return $response->getBody();
    }

}
