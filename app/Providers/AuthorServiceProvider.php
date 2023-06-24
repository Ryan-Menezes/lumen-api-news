<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Eloquent\AuthorRepository;
use App\Services\AuthorService;

use Illuminate\Support\ServiceProvider;

class AuthorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthorService::class, function ($app) {
            return new AuthorService(new AuthorRepository());
        });
    }
}
