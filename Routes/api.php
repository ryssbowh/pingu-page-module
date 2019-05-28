<?php

use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get(Page::getApiUri('index'), ['uses' => 'ApiPageController@index']);
Route::delete(Page::getApiUri('delete'), ['uses' => 'ApiPageController@destroy']);
Route::put(Page::getApiUri('update'), ['uses' => 'ApiPageController@update']);

Route::get(PageLayout::getApiUri('index'), ['uses' => 'ApiLayoutController@index']);
Route::delete(PageLayout::getApiUri('delete'), ['uses' => 'ApiLayoutController@destroy']);
Route::put(PageLayout::getApiUri('update'), ['uses' => 'ApiLayoutController@update']);

Route::get(PageRegion::getApiUri('create'), ['uses' => 'ApiRegionController@create']);
Route::post(PageRegion::getApiUri('store'), ['uses' => 'ApiRegionController@store']);
Route::patch(PageRegion::getApiUri('patch'), ['uses' => 'ApiRegionController@patch']);
Route::delete(PageRegion::getApiUri('delete'), ['uses' => 'ApiRegionController@destroy']);

Route::get(Block::getApiUri('create'), ['uses' => 'ApiBlockController@create']);
Route::put(Block::getApiUri('store'), ['uses' => 'ApiBlockController@store']);
Route::get(Block::getApiUri('index'), ['uses' => 'ApiBlockController@index']);
Route::put(Block::getApiUri('update'), ['uses' => 'ApiBlockController@update']);