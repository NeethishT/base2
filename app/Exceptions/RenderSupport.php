<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;

trait RenderSupport
{
    use OutLander;

    public function getDecodedMessage()
    {
        return json_decode($this->getMessage(), true);
    }

    public function render(): JsonResponse
    {
        $out = $this->getDecodedMessage();
        $message = $out['message'] ?? '';

        if(!isDead($out['message'])) {
            unset($out['message']);
        }

        return $this->buildOutLander($message, $out);
    }
}