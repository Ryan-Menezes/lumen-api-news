<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    public function __construct(
        protected Model $model,
    ) {}

    public function findAll(int $limit = 10, array $orderBy = []): array
    {
        $query = $this->model->query();

        foreach ($orderBy as $key => $value) {
            if (strstr($key, '-')) {
                $key = substr($key, 1);
            }

            $query->orderBy($key, $value);
        }

        return $query
            ->paginate($limit)
            ->appends([
                'order_by' => implode(',', array_keys($orderBy)),
                'limit' => $limit,
            ])
            ->toArray();
    }

    public function findOne(int|string $id): array
    {
        return $this->model
            ->findOrFail($id)
            ->toArray();
    }

    public function findOneBy(string $param, int|string $value): array
    {
        return $this->model
            ->where($param, $value)
            ->firstOrFail()
            ->toArray();
    }

    public function create(array $data): array
    {
        return $this->model
            ->create($data)
            ->toArray();
    }

    public function update(int|string $id, array $data): bool
    {
        return (bool) $this->model
            ->findOrFail($id)
            ->update($data);
    }

    public function updateBy(string $param, int|string $value, array $data): bool
    {
        return (bool) $this->model
            ->where($param, $value)
            ->firstOrFail()
            ->update($data);
    }

    public function delete(int|string $id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    public function deleteBy(string $param, int|string $value): bool
    {
        return (bool) $this->model
            ->where($param, $value)
            ->delete();
    }

    public function searchBy(string $string, array $searchFields, int $limit = 10, array $orderBy = []): array
    {
        $query = $this->model->query();

        if (count($searchFields)) {
            $query->where($searchFields[0], 'LIKE', "%{$string}%");

            foreach ($searchFields as $field) {
                $query->orWhere($field, 'LIKE', "%{$string}%");
            }
        }

        foreach ($orderBy as $key => $value) {
            if (strstr($key, '-')) {
                $key = substr($key, 1);
            }

            $query->orderBy($key, $value);
        }

        return $query
            ->paginate($limit)
            ->appends([
                'order_by' => implode(',', array_keys($orderBy)),
                'q' => $string,
                'limit' => $limit,
            ])
            ->toArray();
    }
}
