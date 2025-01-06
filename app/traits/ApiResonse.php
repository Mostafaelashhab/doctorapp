<?php

namespace App\traits;

use Illuminate\Support\Facades\Storage;

trait ApiResonse
{
    public function success($data = [], $message = '', $code = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => true,
        ], $code);
    }

    public function error($data = [], $message = '', $code = 400)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => false,
        ], $code);
    }
    public function notFound($data = [], $message = '', $code = 404)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => false,
        ], $code);
    }
    public function imagePath($path)
    {
        return Storage::disk('public')->url($path);
    }
}
