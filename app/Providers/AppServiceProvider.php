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

        $this->bootGoogleCustomSocialite();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function bootGoogleCustomSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'google', // extending default google with new full token functionality
            function ($app) use ($socialite) {
                $config = $app['config']['services.google'];
                return $socialite->buildProvider('App\Acme\Socialite\GoogleCustomProvider', $config);
            }
        );
    }
}
