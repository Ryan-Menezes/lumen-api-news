<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use Exception;
use App\Http\Controllers\Controller;
use App\Services\NoticeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class NoticeController extends Controller
{
    protected array $searchFields = [
        'title',
        'subtitle',
        'slug',
        'description',
    ];

    public function __construct(NoticeService $service)
    {
        parent::__construct($service);
    }

    public function findBySlug(string $slug): JsonResponse
    {
        try {
            $result = $this->service->findBySlug($slug);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function findByAuthor(Request $request, int|string $author): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            $result = $this->service->findByAuthor($author, $limit, $orderBy);
            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function updateBySlug(Request $request, string $slug): JsonResponse
    {
        try {
            $data = $request->all();
            $result = $this->service->updateBySlug($slug, $data);
            $response = $this->successResponse([
                'updated' => $result,
            ]);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function deleteBySlug(string $slug): JsonResponse
    {
        try {
            $result = $this->service->deleteBySlug($slug);
            $response = $this->successResponse([
                'deleted' => $result,
            ]);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function deleteByAuthor(int|string $author): JsonResponse
    {
        try {
            $result = $this->service->deleteByAuthor($author);
            $response = $this->successResponse([
                'deleted' => $result,
            ]);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }
}
