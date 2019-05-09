<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Notify, ContextualLinks, Route;
use Pingu\Core\Contracts\ModelController as ModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ModelController;
use Pingu\Jsgrid\Contracts\JsGridController as JsGridControllerContract;
use Pingu\Jsgrid\Traits\JsGridController;
use Pingu\Page\Entities\PageRegion;
use Pingu\Page\Http\Requests\LayoutRegionRequest;

class RegionController  extends BaseController implements ModelControllerContract, JsGridControllerContract
{
    use ModelController, JsGridController;

	public function getModel():string
	{
		return PageRegion::class;
	}
	
	public function listRegions(Request $request)
	{
		$layout = $request->route('PageLayout');
		$regions = $layout->regions;
		ContextualLinks::addLinks($layout->getContextualLinks());
		return view('page::list_regions')->with([
			'layout' => $layout,
			'formUrl' => $request->path(),
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
