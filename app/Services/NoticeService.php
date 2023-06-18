<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Eloquent\NoticeRepository;

class NoticeService extends BaseService
{
    protected NoticeRepository $repository;

    public function __construct(NoticeRepository $repository)
    {
        parent::__construct($repository);
    }

    public function findBySlug(string $slug): array
    {
        return $this->repository->findBySlug($slug);
    }

    public function findByAuthor(int|string $authorId, int $limit = 10, array $orderBy = []): array
    {
        return $this->repository->findByAuthor($authorId, $limit, $orderBy);
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
