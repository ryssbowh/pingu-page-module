<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Notify, ContextualLinks, Route;
use Pingu\Core\Contracts\Controllers\HandlesModelContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\Controllers\HandlesModel;
use Pingu\Jsgrid\Contracts\Controllers\JsGridContract;
use Pingu\Jsgrid\Traits\Controllers\JsGrid;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;
use Pingu\Page\Http\Requests\LayoutRegionRequest;

class RegionController  extends BaseController implements HandlesModelContract, JsGridContract
{
    use HandlesModel, JsGrid;

	public function getModel():string
	{
		return PageRegion::class;
	}
	
	public function listRegions(Request $request, PageLayout $layout)
	{
		ContextualLinks::addModelLinks($layout);
		return view('page::list_regions')->with([
			'layout' => $layout,
			'regions' => $layout->regions,
			'addRegionUri' => PageRegion::transformAjaxUri('create', [$layout], true),
			'saveRegionUri' => PageRegion::transformAjaxUri('patch', [$layout], true),
			'deleteRegionUri' => PageRegion::getAjaxUri('delete', true)
		]);
	}

	public function saveRegions(LayoutRegionRequest $request)
	{
		$layout = $request->route('PageLayout');
		$regions = $request->validated()['regions'];
		foreach($regions as $region){
			if(isset($region['id'])){
				$regionModel = PageRegion::find($region['id']);
				if(isset($region['deleted'])){
					$regionModel->delete();
					continue;
				}
			}
			else{
				$regionModel = new PageRegion;
				$regionModel->page_layout_id = $layout->id;
			}
			$regionModel->name = $region['name'];
			$regionModel->width = $region['width'];
			$regionModel->height = $region['height'];
			$regionModel->save();
		}
		Notify::put('success','Regions saved');
		return back();
	}
}
