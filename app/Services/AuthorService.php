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
}
