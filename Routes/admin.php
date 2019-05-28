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

Route::get(Page::getAdminUri('index'), ['uses' => 'PageController@index'])
	->name('page.admin.pages')
	->middleware('can:manage pages');
Route::get(Page::getAdminUri('edit'), ['uses' => 'PageController@edit'])
	->middleware('can:edit pages');
Route::put(Page::getAdminUri('update'), ['uses' => 'PageController@update'])
	->middleware('can:edit pages');
Route::get(Block::getAdminUri('index'), ['uses' => 'PageController@listBlocks'])
	->middleware('can:view pages blocks');

Route::get(Page::getAdminUri('create'), ['uses' => 'PageController@create'])
	->name('page.admin.pages.create')
	->middleware('can:add pages');
Route::post(Page::getAdminUri('store'), ['uses' => 'PageController@store'])
	->middleware('can:add pages');

Route::get(PageLayout::getAdminUri('index'), ['uses' => 'LayoutController@index'])
	->name('page.admin.layouts')
	->middleware('can:manage layouts');
Route::get(PageLayout::getAdminUri('edit'), ['uses' => 'LayoutController@edit'])
	->middleware('can:edit layouts');

Route::get(PageRegion::getAdminUri('index'), ['uses' => 'RegionController@listRegions', 'contextualLink' => 'regions'])
	->middleware('can:view layouts regions');

Route::get(PageLayout::getAdminUri('create'), ['uses' => 'LayoutController@create'])
	->name('page.admin.layouts.create')
	->middleware('can:add layouts');
Route::post(PageLayout::getAdminUri('store'), ['uses' => 'LayoutController@store'])
	->middleware('can:add layouts');