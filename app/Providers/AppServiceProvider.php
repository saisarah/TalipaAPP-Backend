<?php

namespace App\Providers;

use App\Services\Address\AddressService;
use App\Services\Jitsi\Jitsi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(AddressService::class);
        app()->singleton(Jitsi::class, function () {
            return new Jitsi(
                apiKey: config('app.jitsi.apiKey'),
                appId: config('app.jitsi.appId')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
