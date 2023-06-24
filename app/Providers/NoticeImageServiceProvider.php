<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Eloquent\NoticeImageRepository;
use App\Services\NoticeImageService;

use Illuminate\Support\ServiceProvider;

class NoticeImageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NoticeImageService::class, function ($app) {
            return new NoticeImageService(new NoticeImageRepository());
        });
    }
}
