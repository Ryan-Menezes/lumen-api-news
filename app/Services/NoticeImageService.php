<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\ImageBase64Helper;
use App\Repositories\NoticeImageRepositoryInterface;

class NoticeImageService extends BaseService
{
    public function __construct(NoticeImageRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): array
    {
        if (isset($data['source'])) {
            $data['source'] = ImageBase64Helper::generate($data['source']);
        }

        return parent::create($data);
    }

    public function update(int|string $id, array $data): bool
    {
        if (isset($data['source'])) {
            $data['source'] = ImageBase64Helper::generate($data['source']);
        }

        return parent::update($id, $data);
    }

    public function updateBy(string $param, int|string $value, array $data): bool
    {
        if (isset($data['source'])) {
            $data['source'] = ImageBase64Helper::generate($data['source']);
        }

        return parent::updateBy($param, $value, $data);
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
