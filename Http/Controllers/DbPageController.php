<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Page\Entities\Page;
use Pingu\Core\Http\Controllers\BaseController;

class DbPageController extends BaseController
{
	public function show(Request $request)
	{
		$page = $request->route()->action['page'];
		return view('page::page')->with([
			'page' => $page,
			'layout' => $page->page_layout,
			'regions' => $page->page_layout->regions
		]);
	}
}