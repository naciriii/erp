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
 
        if(config('app.env') != 'local') {

        \URL::forceScheme('https');
    }
     /*Blade::directive('encode', function ($id) {
            return Hashids::encode($id);
        });
     Blade::directive('decode', function ($id) {
            return Hashids::decode($id);
        });*/


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
}
