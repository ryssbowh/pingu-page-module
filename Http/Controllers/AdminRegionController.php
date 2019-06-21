<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\AdminModelController;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;
use Pingu\Page\Http\Requests\LayoutRegionRequest;

class AdminRegionController extends AdminModelController
{
	public function getModel():string
	{
		return PageRegion::class;
	}
	
	public function listRegions(PageLayout $layout)
	{
		\ContextualLinks::addModelLinks($layout);
		return view('page::list_regions')->with([
			'layout' => $layout,
			'regions' => $layout->regions,
			'addRegionUri' => PageRegion::transformAjaxUri('create', $layout, true),
			'saveRegionUri' => PageRegion::transformAjaxUri('patch', $layout, true),
			'deleteRegionUri' => PageRegion::getAjaxUri('delete', true)
		]);
	}
}
