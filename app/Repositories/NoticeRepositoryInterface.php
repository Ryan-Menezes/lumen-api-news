<?php

declare(strict_types=1);

namespace App\Repositories;

interface NoticeRepositoryInterface extends RepositoryInterface
{
    public function findBySlug(string $slug): array;
    public function findByAuthor(int|string $authorId, int $limit = 10, array $orderBy = []): array;
    public function deleteBySlug(string $slug): bool;
    public function deleteByAuthor(int|string $authorId): bool;
}
