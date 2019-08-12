<?php

namespace Pingu\Page;
use Cache, Route, Schema;
use Pingu\Page\Entities\Page;

class Pages{

	private $migrated = false;

	public function __construct()
	{
		$this->migrated = Schema::hasTable('pages');
	}

	/**
	 * Load all pages routes
	 * @return void
	 */
	public function loadRoutes()
	{
		$pages = $this->getPages();
		if(!$pages->isEmpty()){
		    foreach($pages as $page){
		        Route::get('/{'.$page->slug.'}', ['uses' => '\Pingu\Page\Http\Controllers\DbPageController@show']);
		    }
		}
	}

	/**
	 * Get all pages from Cache
	 * @return Collection
	 */
	public function getPages()
	{
		return Cache::rememberForever(config('page.cache-key'), function () {
    		return $this->migrated ? Page::all() : collect();
		});
	}

	/**
	 * Empties Pages Cache
	 * @return void
	 */
	public function emptyRouteCache()
	{
		Cache::forget(config('page.cache-key'));
	}

}