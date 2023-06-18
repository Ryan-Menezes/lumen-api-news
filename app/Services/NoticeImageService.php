<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Eloquent\NoticeImageRepository;

class NoticeImageService extends BaseService
{
    protected NoticeImageRepository $repository;

    public function __construct(NoticeImageRepository $repository)
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
