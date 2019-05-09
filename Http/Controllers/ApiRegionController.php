<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Contracts\ApiModelController as ApiModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ApiModelController;
use Pingu\Page\Entities\PageRegion;

class ApiRegionController extends BaseController implements ApiModelControllerContract
{
	use ApiModelController;

	public function getModel(): string
	{
		return PageRegion::class;
	}
	
	public function listRegionsForLayout(Request $request)
	{
		$layout = $request->route('PageLayout');
		return $layout->regions->toArray();
	}
}
