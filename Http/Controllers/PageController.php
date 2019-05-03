<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Page\Entities\Page;
use Modules\Core\Http\Controllers\Controller;


class PageController extends Controller
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
