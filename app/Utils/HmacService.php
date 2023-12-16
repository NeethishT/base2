<?php

namespace App\Utils;

use App\Exceptions\DefinedFault;

class HmacService
{
    protected string $secretKey;


    /**
     * @throws DefinedFault
     */
    public function __construct()
    {
        //$this->secretKey = settings('hmac_secret');
        $this->secretKey = "test";
    }

    public function generateHmac($build): array
    {
        $timestamp = time();
        $data = $timestamp.json_encode($build);
        $signature = hash_hmac('sha256', $timestamp . $data, $this->secretKey);

        return [
            'X-User-Agent-Override' => $signature,
            'X-Log-Time' => $timestamp
        ];
    }

    /**
     * @throws DefinedFault
     */
    public function verifyHmac($data, $timestamp, $incomingSignature)
    {
        $data = $timestamp.$data;
        $expectedSignature = hash_hmac('sha256', $data, $this->secretKey);

        if(isDead($incomingSignature) || isDead($timestamp)
            || !hash_equals($expectedSignature, $incomingSignature)) {
            raiseError();
        }
    }
}