<?php

namespace Pingu\Page\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\ServiceProvider;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Route, Asset;

class PageServiceProvider extends ServiceProvider
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
        $this->registerFactories();
        $this->loadViewsFrom(base_path('Pingu/Page/Resources/views'), 'page');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        Asset::container('modules')->add('core-js', 'modules/Page/js/Page.js');
        Asset::container('modules')->add('core-css', 'modules/Page/css/Page.css');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('page.pages', \Pingu\Page\Pages::class);
        $this->app->singleton('page.blocks', \Pingu\Page\Blocks::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('page.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'page'
        );
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/page');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'page');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'page');
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
