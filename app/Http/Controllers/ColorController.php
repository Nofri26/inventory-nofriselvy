<?php

namespace App\Http\Controllers;

use App\Http\Requests\Colors;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use App\Services\ColorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function __construct(protected ColorService $colorService) {}

    public function get(): JsonResponse
    {
        $colors = $this->colorService->findAll();

        return $this->sendResponse(ApiResponse::RESPONSE_GET, ColorResource::collection($colors));
    }

    public function index(Request $request): JsonResponse
    {
        $colors = $this->colorService->getAllPaginatedColors($request->all());

        return $this->sendResponse(ApiResponse::RESPONSE_GET, ColorResource::collection($colors), withMeta: true);
    }

    public function store(Colors\StoreColorRequest $request): JsonResponse
    {
        $data  = $request->validated();
        $color = $this->colorService->createColor($data);

        return $this->sendResponse(ApiResponse::RESPONSE_GET, new ColorResource($color), responseCode: 201);
    }

    public function show(Color $color): JsonResponse
    {
        return $this->sendResponse(ApiResponse::RESPONSE_GET, new ColorResource($color));
    }

    public function update(Colors\UpdateColorRequest $request, Color $color): JsonResponse
    {
        $data  = $request->validated();
        $color = $this->colorService->updateColor($color, $data);

        return $this->sendResponse(ApiResponse::RESPONSE_UPDATE, new ColorResource($color));
    }

    public function destroy(Color $color): JsonResponse
    {
        $this->colorService->deleteColor($color);

        return $this->sendResponse(ApiResponse::RESPONSE_DELETE);
    }
}
