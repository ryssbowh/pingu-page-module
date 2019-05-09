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

Route::get($pagesSegment, ['uses' => 'PageController@jsGridList'])
	->name('page.admin.pages')
	->middleware('can:manage pages');
Route::get($pageSegment.'/{'.$pageSlug.'}', ['uses' => 'PageController@edit'])
	->middleware('can:edit pages');
Route::put($pageSegment.'/{'.$pageSlug.'}', ['uses' => 'PageController@update'])
	->middleware('can:edit pages');
Route::get($pageSegment.'/{'.$pageSlug.'}/'.$blocksSegment, ['uses' => 'PageController@listBlocks'])
	->middleware('can:manage pages');

Route::get($pagesSegment.'/create', ['uses' => 'PageController@create'])
	->name('page.admin.pages.create')
	->middleware('can:add pages');
Route::post($pagesSegment, ['uses' => 'PageController@store'])
	->middleware('can:add pages');

Route::get($layoutsSegment, ['uses' => 'LayoutController@jsGridList'])
	->name('page.admin.layouts')
	->middleware('can:manage layouts');
Route::get($layoutSegment.'/{'.$layoutSlug.'}', ['uses' => 'LayoutController@edit'])
	->middleware('can:edit layouts');

Route::get($layoutSegment.'/{'.$layoutSlug.'}/'.$regionsSegment, ['uses' => 'RegionController@listRegions', 'contextualLink' => 'regions'])
	->middleware('can:manage layouts');
Route::put($layoutSegment.'/{'.$layoutSlug.'}/'.$regionsSegment, ['uses' => 'RegionController@saveRegions'])
	->middleware('can:add regions to layouts')
	->middleware('can:remove regions from layouts');

Route::get($layoutsSegment.'/create', ['uses' => 'LayoutController@create'])
	->name('page.admin.layouts.create')
	->middleware('can:add layouts');
Route::post($layoutsSegment, ['uses' => 'LayoutController@store'])
	->middleware('can:add layouts');