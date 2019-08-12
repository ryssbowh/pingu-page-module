<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Page\Entities\Page;
use Pingu\Core\Http\Controllers\BaseController;

class DbPageController extends BaseController
{
	public function show(string $slug)
	{
		$page = Page::findBySlug($slug);
		return view('page::page')->with([
			'page' => $page,
			'regions' => $page->regions
		]);
	}
}
