<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\NoticeImage;
use App\Repositories\NoticeImageRepositoryInterface;

class NoticeImageRepository extends BaseRepository implements NoticeImageRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new NoticeImage());
    }

    public function findByNotice(int|string $noticeId): array
    {
        return $this->model
            ->where('notice_id', $noticeId)
            ->get()
            ->toArray();
    }

    public function deleteByNotice(int|string $noticeId): bool
    {
        return $this->deleteBy('notice_id', $noticeId);
    }
}
