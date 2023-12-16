<?php

namespace App\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

trait Api
{
    public $client;

    public $apiResponse;

    public function curl($postData, $url, $headerContent)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = $headerContent;

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $serverOutput = curl_exec($ch);

        $errno = curl_errno($ch);
        $curlError = curl_error($ch);
        curl_close($ch);
        if ($errno) {
            $responseBody = $curlError;
            $data['api_name'] = $url;
            $data['request'] = $postData;
            $data['exception'] = $responseBody;
        }
        return json_decode($serverOutput, true);
    }

    public function getGuzzleClient()
    {
        if (is_null($this->client)) {
            $this->client = app()->make(Client::class);
        }

        return $this->client;
    }

    public function apiCall($url, $options = [], $method = 'GET')
    {
        try {
            $options['timeout'] = empty($options['timeout']) === false ? $options['timeout'] : 60;

            $response = $this->getGuzzleClient()->request($method, $url, $options);

            $this->statusCode = $response->getStatusCode();

            if ($response->getStatusCode() === 200) {

                $this->apiResponse = $response->getBody()->getContents();

                return $this;
            }
        } catch (ClientException $e) {
            Log::error($e->getMessage());
        }

        return null;
    }

    public function encrypt($data)
    {
        try {
            $key = env('ENCRYPTION_KEY');
            $iv = env('ENCRYPTION_IV');
            $cipher = env('CIPHER');
            return openssl_encrypt($data, $cipher, $key, $options = 0, $iv);
        } catch (\Exception $e) {
            Log::info('Exception' . $e->getMessage());
        }
    }

    public function decrypt($data)
    {
        try {
            $key = env('DECRYPTION_KEY');
            $iv = env('DECRYPTION_IV');
            $cipher = env('CIPHER');

            $decrypted = openssl_decrypt($data, $cipher, $key, $options = 0, $iv);
            return $decrypted = json_decode($decrypted, true);
        } catch (\Exception $e) {
            Log::info('Exception' . $e->getMessage());
        }
    }
}
