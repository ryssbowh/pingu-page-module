<?php

namespace Pingu\Page;
use Cache, Route, Schema;
use Pingu\Page\Entities\Page;

class Pages{

	/**
	 * Cache slug for page entities
	 * @var string
	 */
	private $cache = 'pages.pages';

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
		        Route::get('/'.$page->slug, ['page' => $page, 'uses' => 'Pingu\Page\Http\Controllers\PageController@show']);
		    }
		}
	}

	/**
	 * Get all pages from Cache
	 * @return Collection
	 */
	public function getPages()
	{
		return Cache::rememberForever($this->cache, function () {
    		return $this->migrated ? Page::all() : collect();
		});
	}

	/**
	 * Empties Pages Cache
	 * @return void
	 */
	public function emptyRouteCache()
	{
		Cache::forget($this->cache);
	}

}