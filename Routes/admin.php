<?php

use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
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

Route::get(Page::getAdminUri('index'), ['uses' => 'JsGridPageController@index'])
	->name('page.admin.pages')
	->middleware('can:view pages');
Route::get(Page::getAdminUri('edit'), ['uses' => 'AdminPageController@edit'])
	->middleware('can:edit pages');
Route::put(Page::getAdminUri('update'), ['uses' => 'AdminPageController@update'])
	->middleware('can:edit pages');
Route::get(Block::getAdminUri('index'), ['uses' => 'AdminPageController@listBlocks'])
	->middleware('can:view pages blocks');

Route::get(Page::getAdminUri('create'), ['uses' => 'AdminPageController@create'])
	->name('page.admin.pages.create')
	->middleware('can:add pages');
Route::post(Page::getAdminUri('store'), ['uses' => 'AdminPageController@store'])
	->middleware('can:add pages');

Route::get(PageLayout::getAdminUri('index'), ['uses' => 'JsGridLayoutController@index'])
	->name('page.admin.layouts')
	->middleware('can:view layouts');
Route::get(PageLayout::getAdminUri('edit'), ['uses' => 'AdminLayoutController@edit'])
	->middleware('can:edit layouts');

Route::get(PageRegion::getAdminUri('index'), ['uses' => 'AdminRegionController@listRegions', 'contextualLink' => 'regions'])
	->middleware('can:view layouts regions');

Route::get(PageLayout::getAdminUri('create'), ['uses' => 'AdminLayoutController@create'])
	->name('page.admin.layouts.create')
	->middleware('can:add layouts');
Route::post(PageLayout::getAdminUri('store'), ['uses' => 'AdminLayoutController@store'])
	->middleware('can:add layouts');