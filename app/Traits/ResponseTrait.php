<?php

namespace App\Traits;

/**
 *
 */
trait ResponseTrait
{
    function success($data = [], $message = 'success', $code = 200)
    {
        return response()->json([
            'data'      => $data,
            'message'   => $message
        ], $code);
    }

    function failed($data = [], $message = 'failed!', $code = 400)
    {
        return response()->json([
            'data'      => $data,
            'message'   => $message
        ], $code);
    }
}
