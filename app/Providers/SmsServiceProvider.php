<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('sms', function($app) {
            $adapter = config('sms.default');
            return $app->make(config("sms.drivers.{$adapter}.adapter"));
        });

    }

    public function boot()
    {

    }
}