<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    public function sendResponse($message = 'Action Successfully', $data = null, $withMeta = false, $responseCode = 200): JsonResponse
    {
        if ($withMeta) {
            return response()->json([
                'message' => $message,
                'data'    => $data,
                'meta'    => [
                    'page'        => $data->currentPage(),
                    'perPage'     => $data->perPage(),
                    'total'       => $data->count(),
                    'totalData'   => $data->total(),
                    'totalPage'   => $data->lastPage(),
                    'currentPage' => $data->currentPage(),
                ],
            ], $responseCode);
        } else {
            return response()->json(['message' => $message, 'data' => $data], $responseCode);
        }
    }

    public function sendError($message = 'Action Failed', $data = null, $responseCode = 400): JsonResponse
    {
        return response()->json(['message' => $message, 'data' => $data], $responseCode);
    }
}
