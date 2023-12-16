<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Http\Controllers\Controller;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    use OutLander;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof DefinedFault || $exception instanceof SuccessResponse) {
            return $exception->render();
        }
        [$outMessage, $outData] = $this->generateResponse($exception);
            return $this->buildOutLander(
                $outMessage,
                $outData
            );
    }
    public function getCode(): int
    {
        return 500;
    }

    /**
     * @param Throwable $e
     * @return array
     */
    public function generateResponse(Throwable $e): array
    {
        $outMessage = 'Something went wrong.';
        $outData = [];

        $isLocal = env('API_ENV') === 'local';
        if ($isLocal) {
            $outMessage = $e->getMessage();
            $outData = $e->getTrace();
        }

        if (isDead($outMessage)) {
            Log::error($e);
            $outMessage = $isLocal ? get_class($e) : 'Something went wrong by '.$e->getMessage();
        }

        return [$outMessage, $outData];
    }
}



