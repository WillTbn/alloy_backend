<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function ApiSuccess(string $message, mixed $data = null, $status = 200)
    {

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
    public function ApiError(string $message, mixed $data = null, $status = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
