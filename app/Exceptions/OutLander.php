<?php

namespace App\Exceptions;

use App\Utils\HmacService;
use Illuminate\Http\JsonResponse;

trait OutLander
{
    /**
     * @param $message
     * @param $out
     * @return JsonResponse
     */
    public function buildOutLander($message, $out): JsonResponse
    {
        $build = [
            'message' => $message,
            'data' => $out['data']??$out,
        ];

        return response()->json(
            $build,
            $this->getCode() ?? 500,
            (new HmacService())->generateHmac($build)
        );
    }
}