<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Controller;

class ApiRegionController extends Controller
{

	public function listRegionsForLayout(Request $request)
	{
		$layout = $request->route('PageLayout');
		return $layout->regions->toArray();
	}
}
