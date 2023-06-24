<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\NoticeImageRepositoryInterface;

class NoticeImageService extends BaseService
{
    public function __construct(NoticeImageRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function findByNotice(int|string $noticeId): array
    {
        return $this->repository->findByNotice($noticeId);
    }

    public function deleteByNotice(int|string $noticeId): bool
    {
        return $this->repository->deleteByNotice($noticeId);
    }
}
