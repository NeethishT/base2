<?php

namespace App\Exceptions;

use Exception;

class DefinedFault extends Exception
{
    use RenderSupport;

    public function __construct($message = null, $code = 400, ?Exception $previous = null)
    {
        $message['message'] = $message['message'] ?? 'Bad request.';
        parent::__construct(json_encode($message), $code, $previous);
    }

    public function getDecodedMessage()
    {
        return json_decode($this->getMessage(), true);
    }
}
