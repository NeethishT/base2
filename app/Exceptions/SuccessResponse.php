<?php

namespace App\Exceptions;

use Exception;

/**
 * @method static goodBye($data, $code)
 */
class SuccessResponse extends Exception
{
    use RenderSupport;

    public function __construct($message = null, $code = 200, ?Exception $previous = null)
    {
        $message['message'] = $message['message'] ?? 'Success.';
        parent::__construct(json_encode($message), $code, $previous);
    }

    /**
     * @throws SuccessResponse
     */
    public static function __callStatic($method, $argument)
    {
        throw new self(
            $argument[0],
            $argument[1]
        );
    }
}
