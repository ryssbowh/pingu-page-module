<?php

namespace Pingu\Page\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     *
     * @var string
     */
    protected $namespace = 'Pingu\Page\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Route::model(Page::routeSlug(), Page::class);
        Route::model(PageLayout::routeSlug(), PageLayout::class);
        Route::model(PageRegion::routeSlug(), PageRegion::class);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
    }

    /**
     * Define the admin "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::middleware(['web', 'permission:access admin area'])
            ->prefix('admin')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/admin.php');
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/api.php');
    }
}
