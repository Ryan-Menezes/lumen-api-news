<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AuthorRepositoryInterface;

class AuthorService extends BaseService
{
    public function __construct(AuthorRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /*
    public function create(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = encrypt($data['password']);
        }

        return parent::create($data);
    }

    public function update(int|string $id, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = encrypt($data['password']);
        }

        return parent::update($id, $data);
    }

    public function updateBy(string $param, int|string $value, array $data): bool
    {
        if (isset($data['password'])) {
            $data['password'] = encrypt($data['password']);
        }

        return parent::updateBy($param, $value, $data);
    }
    */
}
