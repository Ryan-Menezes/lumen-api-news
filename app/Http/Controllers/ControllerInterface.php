<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ControllerInterface
{
    public function findAll(Request $request): JsonResponse;
    public function findOne(Request $request, int|string $param): JsonResponse;
    public function create(Request $request): JsonResponse;
    public function update(Request $request, int|string $param): JsonResponse;
    public function delete(int|string $param): JsonResponse;
}
