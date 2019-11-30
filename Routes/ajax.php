<?php

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
// Route::get(Page::getUri('index'), ['uses' => 'JsGridPageController@jsGridIndex'])
// 	->middleware('can:view pages');
// Route::delete(Page::getUri('delete'), ['uses' => 'AjaxPageController@delete'])
// 	->middleware('can:delete pages');
// Route::put(Page::getUri('update'), ['uses' => 'AjaxPageController@update'])
// 	->middleware('can:edit pages');

/**
 * Regions
 */
// Route::get(PageRegion::getUri('create'), ['uses' => 'AjaxRegionController@create'])
// 	->middleware('can:manage page layouts');
// Route::post(PageRegion::getUri('store'), ['uses' => 'AjaxRegionController@store'])
// 	->middleware('can:manage page layouts');
// Route::patch(PageRegion::getUri('patch'), ['uses' => 'AjaxRegionController@patch'])
// 	->middleware('can:manage page layouts');
// Route::delete(PageRegion::getUri('delete'), ['uses' => 'AjaxRegionController@delete'])
// 	->middleware('can:manage page layouts');

/**
 * Blocks 
 */
// Route::patch(Page::getUri('patchBlocks'), ['uses' => 'AjaxPageController@patchBlocks'])
// 	->middleware('can:manage page blocks');
// Route::get(Page::getUri('blocks'), ['uses' => 'AjaxPageController@listBlocks'])
// 	->middleware('can:manage page blocks');