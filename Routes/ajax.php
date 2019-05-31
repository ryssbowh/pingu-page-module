<?php

use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;

/*
|--------------------------------------------------------------------------
| Ajax Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ajax web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group prefixed with ajax which
| contains the "ajax" middleware groups.
|
*/

/**
 * Pages
 */
Route::get(Page::getAjaxUri('index'), ['uses' => 'AjaxPageController@index'])
	->middleware('can:view pages');
Route::delete(Page::getAjaxUri('delete'), ['uses' => 'AjaxPageController@destroy'])
	->middleware('can:delete pages');
Route::put(Page::getAjaxUri('update'), ['uses' => 'AjaxPageController@update'])
	->middleware('can:edit pages');

/**
 * Layouts
 */
Route::get(PageLayout::getAjaxUri('index'), ['uses' => 'AjaxLayoutController@index'])
	->middleware('can:view layouts');
Route::delete(PageLayout::getAjaxUri('delete'), ['uses' => 'AjaxLayoutController@destroy'])
	->middleware('can:delete layouts');
Route::put(PageLayout::getAjaxUri('update'), ['uses' => 'AjaxLayoutController@update'])
	->middleware('can:edit layouts');

/**
 * Regions
 */
Route::get(PageRegion::getAjaxUri('create'), ['uses' => 'AjaxRegionController@create'])
	->middleware('can:manage layouts regions');
Route::post(PageRegion::getAjaxUri('store'), ['uses' => 'AjaxRegionController@store'])
	->middleware('can:manage layouts regions');
Route::patch(PageRegion::getAjaxUri('patch'), ['uses' => 'AjaxRegionController@patch'])
	->middleware('can:manage layouts regions');
Route::delete(PageRegion::getAjaxUri('delete'), ['uses' => 'AjaxRegionController@destroy'])
	->middleware('can:manage layouts regions');

/**
 * Blocks
 */
Route::get(Block::getAjaxUri('create'), ['uses' => 'AjaxBlockController@create'])
	->middleware('can:manage pages blocks');
Route::post(Block::getAjaxUri('store'), ['uses' => 'AjaxBlockController@store'])
	->middleware('can:manage pages blocks');
Route::get(Block::getAjaxUri('index'), ['uses' => 'AjaxBlockController@index'])
	->middleware('can:manage pages blocks');
Route::patch(Block::getAjaxUri('patch'), ['uses' => 'AjaxBlockController@patch'])
	->middleware('can:manage pages blocks');
Route::get(Block::getAjaxUri('edit'), ['uses' => 'AjaxBlockController@edit'])
	->middleware('can:manage pages blocks');
Route::put(Block::getAjaxUri('update'), ['uses' => 'AjaxBlockController@update'])
	->middleware('can:manage pages blocks');