<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Author;
use App\Repositories\AuthorRepositoryInterface;

class AuthorRepository extends BaseRepository implements AuthorRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Author());
    }
}
