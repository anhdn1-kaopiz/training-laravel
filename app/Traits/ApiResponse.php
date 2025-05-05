<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

trait ApiResponse
{
    /**
     * Success Response
     */
    protected function successResponse($data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Error Response
     */
    protected function errorResponse(string $message, int $code): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null
        ], $code);
    }

    /**
     * Show All Response
     */
    protected function showAll($data, string $message = null, int $code = 200): JsonResponse
    {
        if ($data instanceof Collection) {
            $data = $this->transformCollection($data);
        }

        if ($data instanceof LengthAwarePaginator) {
            $data = $this->transformPagination($data);
        }

        return $this->successResponse($data, $message, $code);
    }

    /**
     * Show One Response
     */
    protected function showOne($data, string $message = null, int $code = 200): JsonResponse
    {
        if ($data instanceof JsonResource) {
            $data = $data->response()->getData(true)['data'];
        }

        return $this->successResponse($data, $message, $code);
    }

    /**
     * Transform Collection
     */
    protected function transformCollection(Collection $collection): array
    {
        return $collection->toArray();
    }

    /**
     * Transform Pagination
     */
    protected function transformPagination(LengthAwarePaginator $paginator): array
    {
        return [
            'data' => $paginator->items(),
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem()
            ]
        ];
    }
}
