<?php

use Pingu\Page\Entities\Page;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

foreach (Page::all() as $page) {
    Route::get($page->slug, ['uses' => 'PageWebController@view'])
        ->name('pages.'.$page->machineName);
}