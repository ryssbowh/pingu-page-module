<?php

namespace Pingu\Page\Providers;

use Illuminate\Database\Eloquent\Factory;
use Pingu\Core\Support\ModuleServiceProvider;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Providers\RouteServiceProvider;
use Route, Asset;

class PageServiceProvider extends ModuleServiceProvider
{
    protected $entities = [
        Page::class
    ];

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
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'page');

        Asset::container('modules')->add('page-js', 'module-assets/Page.js');
        Asset::container('modules')->add('page-css', 'module-assets/Page.css');

        \JsConfig::setMany(
            [
            'page.uris.addBlock' => Page::uris()->get('addBlock', ajaxPrefix()),
            'page.uris.patchBlocks' => Page::uris()->get('patchBlocks', ajaxPrefix())
            ]
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->singleton('page.pages', \Pingu\Page\Pages::class);
        $this->app->register(RouteServiceProvider::class);
        $this->registerEntities($this->entities);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
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
