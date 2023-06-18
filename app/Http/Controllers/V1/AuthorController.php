<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AuthorService;

class AuthorController extends Controller
{
    protected array $searchFields = [
        'first_name',
        'last_name',
    ];

    protected function __construct(AuthorService $service)
    {
        parent::__construct($service);
    }
}
