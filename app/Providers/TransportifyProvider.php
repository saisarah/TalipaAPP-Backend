<?php

namespace App\Providers;

use App\Services\Transportify\Transportify;
use Illuminate\Support\ServiceProvider;

class TransportifyProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('transportify', function () {
            $mode = config('transportify.mode');
            $config = config("transportify.$mode");

            $transportify = new Transportify();
            $transportify->setApiKey($config['api_key']);
            $transportify->setBaseUrl($config['baseurl']);
            
            return $transportify;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
