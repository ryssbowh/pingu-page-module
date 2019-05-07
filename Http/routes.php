<?php

use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;

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
/**
 * Route model binding
 */
Route::model($pageSlug, Page::class);
Route::model($layoutSlug, PageLayout::class);
Route::model($regionSlug, PageRegion::class);

/**
 * Admin routes
 */
Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Pingu\Page\Http\Controllers'], function() use ($pageSlug, $pageSegment, $pagesSegment, $layoutSegment,$layoutsSegment, $layoutSlug, $regionsSegment, $blocksSegment)
{
    Route::get($pagesSegment, ['uses' => 'AdminPageController@jsGridList', 'model' => Page::class])->name('admin.pages');
    Route::get($pageSegment.'/{'.$pageSlug.'}', ['uses' => 'AdminPageController@edit']);
	Route::put($pageSegment.'/{'.$pageSlug.'}', ['uses' => 'AdminPageController@update']);
    Route::get($pageSegment.'/{'.$pageSlug.'}/'.$blocksSegment, ['uses' => 'AdminPageController@listBlocks']);

    Route::get($pagesSegment.'/create', ['uses' => 'AdminPageController@create', 'model' => Page::class]);
    Route::post($pagesSegment, ['uses' => 'AdminPageController@store', 'model' => Page::class]);

    Route::get($layoutsSegment, ['uses' => 'AdminLayoutController@jsGridList', 'model' => PageLayout::class])->name('admin.pageLayouts');
    Route::get($layoutSegment.'/{'.$layoutSlug.'}', ['uses' => 'AdminLayoutController@edit']);
    Route::get($layoutSegment.'/{'.$layoutSlug.'}/'.$regionsSegment, ['uses' => 'AdminRegionController@listRegions', 'contextualLink' => 'regions']);
    Route::put($layoutSegment.'/{'.$layoutSlug.'}/'.$regionsSegment, ['uses' => 'AdminRegionController@saveRegions']);

    Route::get($layoutsSegment.'/create', ['uses' => 'AdminLayoutController@create', 'model' => PageLayout::class]);
    Route::post($layoutsSegment, ['uses' => 'AdminLayoutController@store', 'model' => PageLayout::class]);

});

/**
 * API routes
 */
Route::group(['middleware' => 'api', 'prefix' => 'api'], function() use ($pagesSegment,$layoutsSegment,$layoutSegment, $regionsSegment, $layoutSlug, $blocksSegment, $pageSegment, $pageSlug)
{
	Route::post($pagesSegment, ['uses' => 'Pingu\Core\Http\Controllers\ApiModelController@index', 'model' => Page::class]);
    Route::delete($pagesSegment, ['uses' => 'Pingu\Core\Http\Controllers\ApiModelController@destroy', 'model' => Page::class]);
    Route::put($pagesSegment, ['uses' => 'Pingu\Core\Http\Controllers\ApiModelController@update', 'model' => Page::class]);

	Route::post($layoutsSegment, ['uses' => 'Pingu\Core\Http\Controllers\ApiModelController@index', 'model' => PageLayout::class]);
    Route::delete($layoutsSegment, ['uses' => 'Pingu\Core\Http\Controllers\ApiModelController@destroy', 'model' => PageLayout::class]);
    Route::put($layoutsSegment, ['uses' => 'Pingu\Core\Http\Controllers\ApiModelController@update', 'model' => PageLayout::class]);
	Route::post($layoutSegment.'/{'.$layoutSlug.'}/'.$regionsSegment, ['uses' => 'Pingu\Page\Http\Controllers\ApiRegionController@listRegionsForLayout']);

    Route::post($blocksSegment.'/create/{provider}', ['uses' => 'Pingu\Page\Http\Controllers\ApiBlockController@create']);
    Route::post($blocksSegment.'/save', ['uses' => 'Pingu\Page\Http\Controllers\ApiBlockController@save']);

    Route::post($pageSegment.'/{'.$pageSlug.'}/'.$blocksSegment, ['uses' => 'Pingu\Page\Http\Controllers\ApiBlockController@listBlocksForPage']);
    Route::put($pageSegment.'/{'.$pageSlug.'}/'.$blocksSegment, ['uses' => 'Pingu\Page\Http\Controllers\ApiBlockController@updateBlocks']);
});

/**
 * Database pages
 */
Pages::loadRoutes();