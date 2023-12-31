<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Services\AuthorService;

class AuthorController extends Controller
{
    protected array $searchFields = [
        'first_name',
        'last_name',
    ];

    public function __construct(AuthorService $service)
    {
        parent::__construct($service);
    }
}
