<?php

namespace App\Http\Controllers;

use App\Http\Resources\SizeResource;
use App\Models\Size;
use App\Services\SizeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function __construct(protected SizeService $service) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $sizes = $this->service->findAll($filters);

        return $this->sendResponse(ApiResponse::RESPONSE_GET, SizeResource::collection($sizes));
    }
}
