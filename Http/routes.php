<?php

use Modules\Page\Entities\Page;
use Modules\Page\Entities\PageLayout;
use Modules\Page\Entities\PageRegion;

$pageSegment = Page::urlSegment();
$pagesSegment = Page::urlSegments();
$pageSlug = Page::routeSlug();
$layoutSegment = PageLayout::urlSegment();
$layoutsSegment = PageLayout::urlSegments();
$layoutSlug = PageLayout::routeSlug();
$regionSegment = PageRegion::urlSegment();
$regionsSegment = PageRegion::urlSegments();
$regionSlug = PageRegion::routeSlug();

Route::model($pageSlug, Page::class);
Route::model($layoutSlug, PageLayout::class);

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Page\Http\Controllers'], function() use ($pageSlug, $pageSegment, $pagesSegment)
{
    Route::get($pagesSegment, ['uses' => 'AdminController@jsGridList', 'model' => Page::class])->name('admin.pages');
    Route::get($pageSegment.'/{'.$pageSlug.'}', ['uses' => 'AdminController@edit']);
	Route::put($pageSegment.'/{'.$pageSlug.'}', ['uses' => 'AdminController@update']);

    Route::get($pagesSegment.'/create', ['uses' => 'AdminController@create', 'model' => Page::class]);
    Route::post($pagesSegment, ['uses' => 'AdminController@store', 'model' => Page::class]);

});

Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => 'Modules\Page\Http\Controllers'], function() use ($layoutSegment,$layoutsSegment, $layoutSlug, $regionsSegment)
{
    Route::get($layoutsSegment, ['uses' => 'AdminController@jsGridList', 'model' => PageLayout::class])->name('admin.pageLayouts');
    Route::get($layoutSegment.'/{'.$layoutSlug.'}', ['uses' => 'AdminController@edit']);
    Route::get($layoutSegment.'/{'.$layoutSlug.'}/'.$regionsSegment, ['uses' => 'AdminController@relatedJsGridList', 'contextualLink' => 'regions']);

    Route::get($layoutsSegment.'/create', ['uses' => 'AdminController@create', 'model' => PageLayout::class]);
    Route::post($layoutsSegment, ['uses' => 'AdminController@store', 'model' => PageLayout::class]);
});

Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'Modules\Core\Http\Controllers'], function() use ($pagesSegment,$layoutsSegment, $regionsSegment)
{
	Route::post($pagesSegment, ['uses' => 'ApiModelController@index', 'model' => Page::class]);
    Route::delete($pagesSegment, ['uses' => 'ApiModelController@destroy', 'model' => Page::class]);
    Route::put($pagesSegment, ['uses' => 'ApiModelController@update', 'model' => Page::class]);

	Route::post($layoutsSegment, ['uses' => 'ApiModelController@index', 'model' => PageLayout::class]);
    Route::delete($layoutsSegment, ['uses' => 'ApiModelController@destroy', 'model' => PageLayout::class]);
    Route::put($layoutsSegment, ['uses' => 'ApiModelController@update', 'model' => PageLayout::class]);

	Route::post($regionsSegment, ['uses' => 'ApiModelController@index', 'model' => PageRegion::class]);
    Route::delete($regionsSegment, ['uses' => 'ApiModelController@destroy', 'model' => PageRegion::class]);
    Route::put($regionsSegment, ['uses' => 'ApiModelController@update', 'model' => PageRegion::class]);
});