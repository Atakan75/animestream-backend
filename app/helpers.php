<?php

use Illuminate\Support\Facades\Lang;

if (!function_exists('response_success')) {
    function response_success($data, $status = 200) {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status);
    }
}

if (!function_exists('response_error')) {
    function response_error($message, $status = 400) {
        return response()->json([
            'success' => false,
            'message' => Lang::get($message),
        ], $status);
    }
}
