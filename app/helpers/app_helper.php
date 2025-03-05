<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

function sendHttpResponse($message, $code, $data = [], $exception = null ) : JsonResponse
{
    $code = $code >= 200 && $code <= 500 ? $code : 400;
    if($exception){
        Log::error($exception);
    }
    $data['message'] = $message;

    return response()->json(
        $data,
        $code
    );
}