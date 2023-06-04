<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

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
            'timeout' => 10.0,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " . env('PAYSTAR_GATEWAY_ID')
            ],
        ]);
    }

    private function sign(string $data): bool|string
    {
        return hash_hmac($this->algorithm, $data, env('PAYSTAR_KEY'));
    }

    /**
     * @param int $amount
     * @param int $order_id
     *
     * @return \stdClass
     * @throws GuzzleException
     */
    public function create(int $amount, int $order_id): \stdClass
    {
        $body = [
            'amount' => (double) $amount,
            'order_id' => (string) $order_id,
            'callback' => env('PAYSTAR_CALLBACK_URL'),
            'sign' => $this->sign($amount . "#" . $order_id . "#" . env('PAYSTAR_CALLBACK_URL')),
            'callback_method' => 1,
        ];

        return json_decode($this->client->post('pardakht/create', [
            'form_params' => $body
        ])->getBody()->getContents());
    }

    /**
     * @param string $token
     *
     * @return \stdClass
     * @throws GuzzleException
     */
    public function payment(string $token): \stdClass
    {
        $body = [
            'token' => $token,
        ];

        return json_decode($this->client->post('pardakht/payment', [
            'allow_redirects' => [
                'strict' => true
            ],
            'form_params' => $body
        ])->getBody()->getContents());
    }

    /**
     * @param int $amount
     * @param string $ref_num
     * @param string $card_number
     * @param string $tracking_code
     *
     * @return \stdClass
     * @throws GuzzleException
     */
    public function verify(int $amount, string $ref_num, string $card_number, string $tracking_code): \stdClass
    {
        $body = [
            'ref_num' => $ref_num,
            'amount' => $amount,
            'sign' => $this->sign($amount . "#" . $ref_num . "#" . $card_number . "#" . $tracking_code),
        ];

        return json_decode($this->client->post('pardakht/verify', [
            'form_params' => $body
        ])->getBody()->getContents());
    }

}
