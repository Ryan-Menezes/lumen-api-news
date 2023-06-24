<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\ServiceInterface;

abstract class Controller extends BaseController implements ControllerInterface
{
    protected ServiceInterface $service;
    protected array $searchFields = [];

    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    public function findAll(Request $request): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);
            $searchString = $request->get('q', '');

            if (!empty($searchString)) {
                $result = $this->service->searchBy(
                    $searchString,
                    $this->searchFields,
                    $limit,
                    $orderBy,
                );
            } else {
                $result = $this->service->findAll($limit, $orderBy);
            }

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function findOne(Request $request, int|string $id): JsonResponse
    {
        try {
            $result = $this->service->findOne($id);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = $this->service->create($data);
            $response = $this->successResponse($result, Response::HTTP_CREATED);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function update(Request $request, int|string $id): JsonResponse
    {
        try {
            $data = $request->all();
            $result = $this->service->update($id, $data);
            $response = $this->successResponse([
                'updated' => $result,
            ]);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function delete(int|string $id): JsonResponse
    {
        try {
            $result = $this->service->delete($id);
            $response = $this->successResponse([
                'deleted' => $result,
            ]);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    protected function successResponse(array $data, int $statusCode = Response::HTTP_OK): array
    {
        return [
            'status_code' => $statusCode,
            'data' => $data,
        ];
    }

    protected function errorResponse(Exception $e, int $statusCode = Response::HTTP_BAD_REQUEST): array
    {
        return [
            'status_code' => $statusCode,
            'error' => true,
            'error_description' => $e->getMessage(),
        ];
    }
}
