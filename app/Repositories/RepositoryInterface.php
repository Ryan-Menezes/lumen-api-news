<?php

declare(strict_types=1);

namespace App\Repositories;

interface RepositoryInterface
{
    public function findAll(int $limit = 10, array $orderBy = []): array;
    public function findOne(int|string $id): array;
    public function findOneBy(string $param, int|string $value): array;
    public function create(array $data): array;
    public function update(int|string $id, array $data): bool;
    public function updateBy(string $param, int|string $value, array $data): bool;
    public function delete(int|string $id): bool;
    public function deleteBy(string $param, int|string $value): bool;
    public function searchBy(string $string, array $searchFields, int $limit = 10, array $orderBy = []): array;
}
