<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\RepositoryInterface;

abstract class BaseService implements ServiceInterface
{
    public function __construct(
        protected RepositoryInterface $repository
    )
    {}

    public function findAll(int $limit = 10, array $orderBy = []): array
    {
        return $this->repository->findAll($limit, $orderBy);
    }

    public function findOne(int|string $id): array
    {
        return $this->repository->findOne($id);
    }

    public function findOneBy(string $param, int|string $value): array
    {
        return $this->repository->findOneBy($param, $value);
    }

    public function create(array $data): array
    {
        return $this->repository->create($data);
    }

    public function update(int|string $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function updateBy(string $param, int|string $value, array $data): bool
    {
        return $this->repository->updateBy($param, $value, $data);
    }

    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }

    public function deleteBy(string $param, int|string $value): bool
    {
        return $this->repository->deleteBy($param, $value);
    }

    public function searchBy(string $string, array $searchFields, int $limit = 10, array $orderBy = []): array
    {
        return $this->repository->searchBy($string, $searchFields, $limit, $orderBy);
    }
}
