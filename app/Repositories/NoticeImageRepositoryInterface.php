<?php

declare(strict_types=1);

namespace App\Repositories;

interface NoticeImageRepositoryInterface extends RepositoryInterface
{
    public function findByNotice(int|string $noticeId): array;
    public function deleteByNotice(int|string $noticeId): bool;
}
