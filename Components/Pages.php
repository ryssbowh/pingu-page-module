<?php

namespace Modules\Page\Components;
use Cache, Route;
use Modules\Page\Entities\Page;

class Pages{

	/**
	 * Cache slug for page entities
	 * @var string
	 */
	private $cache = 'pages.pages';

	/**
	 * Load all pages routes
	 * @return void
	 */
	public function loadRoutes()
	{
		$pages = $this->getPages();
		if(!$pages->isEmpty()){
		    foreach($pages as $page){
		        Route::get('/'.$page->slug, ['page' => $page, 'uses' => 'Modules\Page\Http\Controllers\PageController@show']);
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
    		return Page::all();
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