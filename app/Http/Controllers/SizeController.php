<?php

namespace App\Http\Controllers;

use App\Http\Requests\Size\StoreRequest;
use App\Http\Resources\SizeResource;
use App\Services\SizeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function __construct(protected SizeService $service) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $sizes   = $this->service->findAll($filters);

        return $this->sendResponse(ApiResponse::RESPONSE_GET, SizeResource::collection($sizes), meta: true);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $size = $this->service->create($data);

        return $this->sendResponse(ApiResponse::RESPONSE_CREATE, new SizeResource($size), responseCode: 201);
    }
}
