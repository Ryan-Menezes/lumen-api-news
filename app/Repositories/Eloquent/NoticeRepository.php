<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Notice;
use App\Repositories\NoticeRepositoryInterface;

class NoticeRepository extends BaseRepository implements NoticeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Notice());
    }

    public function findBySlug(string $slug): array
    {
        return $this->findOneBy('slug', $slug);
    }

    public function findByAuthor(int|string $authorId, int $limit = 10, array $orderBy = []): array
    {
        $query = $this->model->where('author_id', $authorId);

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

    public function updateBySlug(string $slug, array $data): bool
    {
        return (bool) $this->model
            ->where('slug', $slug)
            ->firstOrFail()
            ->update($data);
    }

    public function deleteBySlug(string $slug): bool
    {
        return $this->deleteBy('slug', $slug);
    }

    public function deleteByAuthor(int|string $authorId): bool
    {
        return $this->deleteBy('author_id', $authorId);
    }
}
