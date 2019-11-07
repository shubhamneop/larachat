<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ChatKit', function() {
            return new \Chatkit\Chatkit([
                'instance_locator' => config('services.chatkit.locator'),
                'key' => config('services.chatkit.secret'),
            ]);
        });
    
    }
}
