<?php

use Pingu\Page\Entities\Block;
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

$pageSegment = Page::urlSegment();
$pagesSegment = Page::urlSegments();
$pageSlug = Page::routeSlug();
$layoutSegment = PageLayout::urlSegment();
$layoutsSegment = PageLayout::urlSegments();
$layoutSlug = PageLayout::routeSlug();
$regionSegment = PageRegion::urlSegment();
$regionsSegment = PageRegion::urlSegments();
$regionSlug = PageRegion::routeSlug();
$blocksSegment = Block::urlSegments();

Route::post($pagesSegment, ['uses' => 'ApiPageController@index']);
Route::delete($pagesSegment, ['uses' => 'ApiPageController@destroy']);
Route::put($pagesSegment, ['uses' => 'ApiPageController@update']);

Route::post($layoutsSegment, ['uses' => 'ApiLayoutController@index']);
Route::delete($layoutsSegment, ['uses' => 'ApiLayoutController@destroy']);
Route::put($layoutsSegment, ['uses' => 'ApiLayoutController@update']);
Route::post($layoutSegment.'/{'.$layoutSlug.'}/'.$regionsSegment, ['uses' => 'ApiRegionController@listRegionsForLayout']);

Route::post($blocksSegment.'/create/{provider}', ['uses' => 'ApiBlockController@create']);
Route::post($blocksSegment.'/save', ['uses' => 'ApiBlockController@save']);

Route::post($pageSegment.'/{'.$pageSlug.'}/'.$blocksSegment, ['uses' => 'ApiBlockController@listBlocksForPage']);
Route::put($pageSegment.'/{'.$pageSlug.'}/'.$blocksSegment, ['uses' => 'ApiBlockController@updateBlocks']);