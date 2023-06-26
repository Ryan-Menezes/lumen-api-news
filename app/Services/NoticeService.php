<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\NoticeRepositoryInterface;
use Illuminate\Support\Str;

class NoticeService extends BaseService
{
    public function __construct(NoticeRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /*
    public function create(array $data): array
    {
        if (!isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title'] . '-' . $data['subtitle']);
        }

        return parent::create($data);
    }
    */

    public function findBySlug(string $slug): array
    {
        return $this->repository->findBySlug($slug);
    }

    public function findByAuthor(int|string $authorId, int $limit = 10, array $orderBy = []): array
    {
        return $this->repository->findByAuthor($authorId, $limit, $orderBy);
    }

    public function updateBySlug(string $slug, array $data): bool
    {
        return $this->repository->updateBySlug($slug, $data);
    }

    public function deleteBySlug(string $slug): bool
    {
        return $this->repository->deleteBySlug($slug);
    }

    public function deleteByAuthor(int|string $authorId): bool
    {
        return $this->repository->deleteByAuthor($authorId);
    }
}
