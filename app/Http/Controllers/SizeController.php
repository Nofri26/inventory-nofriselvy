<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sizes;
use App\Http\Resources\SizeResource;
use App\Models\Size;
use App\Services\SizeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function __construct(protected SizeService $sizeService) {}

    public function get(): JsonResponse
    {
        $sizes = $this->sizeService->findAll();

        return $this->sendResponse(ApiResponse::RESPONSE_GET, SizeResource::collection($sizes));
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->all();
        $sizes   = $this->sizeService->getAllPaginatedSizes($filters);

        return $this->sendResponse(ApiResponse::RESPONSE_GET, SizeResource::collection($sizes), withMeta: true);
    }

    public function store(Sizes\StoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $size = $this->sizeService->create($data);

        return $this->sendResponse(ApiResponse::RESPONSE_CREATE, new SizeResource($size), responseCode: 201);
    }

    public function show(Size $size): JsonResponse
    {
        return $this->sendResponse(ApiResponse::RESPONSE_GET, new SizeResource($size));
    }

    public function update(Sizes\UpdateRequest $request, Size $size): JsonResponse
    {
        $data = $request->validated();
        $size = $this->sizeService->update($size, $data);

        return $this->sendResponse(ApiResponse::RESPONSE_UPDATE, new SizeResource($size));
    }

    public function destroy(Size $size): JsonResponse
    {
        $this->sizeService->delete($size);

        return $this->sendResponse(ApiResponse::RESPONSE_DELETE);
    }
}
