<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use Exception;
use App\Http\Controllers\Controller;
use App\Services\NoticeImageService;
use Illuminate\Http\JsonResponse;

class NoticeImageController extends Controller
{
    protected NoticeImageService $service;

    protected function __construct(NoticeImageService $service)
    {
        parent::__construct($service);
    }

    public function findByNotice(int|string $notice): JsonResponse
    {
        try {
            $result = $this->service->findByNotice($notice);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function deleteByNotice(int|string $notice): JsonResponse
    {
        try {
            $result = $this->service->deleteByNotice($notice);
            $response = $this->successResponse([
                'deleted' => $result,
            ]);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }
}
