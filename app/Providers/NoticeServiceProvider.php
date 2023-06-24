<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Eloquent\NoticeRepository;
use App\Services\NoticeService;

use Illuminate\Support\ServiceProvider;

class NoticeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NoticeService::class, function ($app) {
            return new NoticeService(new NoticeRepository());
        });
    }
}
