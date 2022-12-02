<?php

namespace App\Providers;

use App\Services\SmsService\SmsLogAdapter;
use App\Services\SmsService\SmsMoviderAdapter;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('sms', function() {
            switch (config('sms.default')) {
                case 'movider':
                    return new SmsMoviderAdapter;
                default:
                    return new SmsLogAdapter;
            }
        });        
    }

    public function boot()
    {

    }
}