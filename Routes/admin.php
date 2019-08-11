<?php

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

Route::get(Page::getUri('index'), ['uses' => 'JsGridPageController@index'])
	->name('page.admin.pages')
	->middleware('can:view pages');
Route::get(Page::getUri('edit'), ['uses' => 'AdminPageController@edit'])
	->middleware('can:edit pages');
Route::put(Page::getUri('update'), ['uses' => 'AdminPageController@update'])
	->middleware('can:edit pages');
Route::get(Page::getUri('create'), ['uses' => 'AdminPageController@create'])
	->name('page.admin.pages.create')
	->middleware('can:add pages');
Route::post(Page::getUri('store'), ['uses' => 'AdminPageController@store'])
	->middleware('can:add pages');

/**
 * Layouts
 */
Route::get(Page::getUri('editLayout'), ['uses' => 'AdminPageController@editLayout'])
	->middleware('can:view page layouts');
Route::get(Page::getUri('editBlocks'), ['uses' => 'AdminPageController@editBlocks'])
	->middleware('can:view page blocks');