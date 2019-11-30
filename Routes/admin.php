<?php

use Pingu\Block\Entities\Block;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

/*
|--------------------------------------------------------------------------
| Admin Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group prefixed with admin which
| contains the "web" middleware group and the permission middleware "can:access admin area".
|
*/

/**
 * Pages
 */
// Route::get(Page::getUri('index'), ['uses' => 'JsGridPageController@index'])
// 	->name('page.admin.pages')
// 	->middleware('can:view pages');
// Route::get(Page::getUri('edit'), ['uses' => 'AdminPageController@edit'])
// 	->middleware('can:edit pages');
// Route::put(Page::getUri('update'), ['uses' => 'AdminPageController@update'])
// 	->middleware('can:edit pages');
// Route::get(Page::getUri('create'), ['uses' => 'AdminPageController@create'])
// 	->name('page.admin.pages.create')
// 	->middleware('can:add pages');
// Route::post(Page::getUri('store'), ['uses' => 'AdminPageController@store'])
// 	->middleware('can:add pages');
// Route::get(Page::getUri('blocks'), ['uses' => 'AdminPageController@blocks'])
// 	->middleware('can:manage page layouts');

/**
 * Regions
 */
// Route::get(PageRegion::getUri('index'), ['uses' => 'AdminRegionController@index'])
// 	->middleware('can:view page layouts');
// Route::get(PageRegion::getUri('create'), ['uses' => 'AdminRegionController@create'])
// 	->middleware('can:manage page layouts');
// Route::post(PageRegion::getUri('store'), ['uses' => 'AdminRegionController@store'])
// 	->middleware('can:manage page layouts');
// Route::patch(PageRegion::getUri('patch'), ['uses' => 'AdminRegionController@patch'])
// 	->middleware('can:manage page layouts');
// Route::delete(PageRegion::getUri('delete'), ['uses' => 'AdminRegionController@delete'])
// 	->middleware('can:manage page layouts');
// Route::get(PageRegion::getUri('delete'), ['uses' => 'AdminRegionController@confirmDelete'])
// 	->middleware('can:manage page layouts');
