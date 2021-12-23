<?php

namespace App\Providers;

use App\Interfaces\CodeInterface;
use App\Interfaces\TitleInterface;
use App\Services\CodeService;
use App\Services\ShortLinkService;
use App\Services\TitleService;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ShortLinkInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ShortLinkInterface::class,
            ShortLinkService::class);

        $this->app->bind(
            CodeInterface::class,
            CodeService::class);

        $this->app->bind(
            TitleInterface::class,
            TitleService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
