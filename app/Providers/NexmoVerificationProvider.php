<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\NexmoVerification;

class NexmoVerificationProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Library\Services\NexmoVerification', function($app){
            return new NexmoVerification();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->post('verification/request','App\Library\Services\NexmoVerification@request');
        $this->app['router']->post('verification/verify','App\Library\Services\NexmoVerification@verify');
    }
}
