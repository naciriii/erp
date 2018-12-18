<?php

namespace Modules\Stores\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class StoresServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->when('Modules\Stores\Http\Controllers\Store\CategoryController')
            ->needs('Modules\Stores\Repositories\Contracts\BaseRepository')
            ->give('Modules\Stores\Repositories\CategoryRepository');

        $this->app->when('Modules\Stores\Http\Controllers\Store\CustomerController')
            ->needs('Modules\Stores\Repositories\Contracts\BaseRepository')
            ->give('Modules\Stores\Repositories\CustomerRepository');

        $this->app->when('Modules\Stores\Http\Controllers\Store\ProductController')
            ->needs('Modules\Stores\Repositories\Contracts\BaseRepository')
            ->give('Modules\Stores\Repositories\ProductRepository');

        $this->app->when('Modules\Stores\Http\Controllers\StoreController')
            ->needs('Modules\Stores\Repositories\Contracts\BaseRepository')
            ->give('Modules\Stores\Repositories\StoreRepository');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('stores.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'stores'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/stores');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/stores';
        }, \Config::get('view.paths')), [$sourcePath]), 'stores');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/stores');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'stores');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'stores');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
