<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ModelController;
use Modules\JsGrid\Http\Controllers\JsGridController;
use Modules\Page\Entities\BlockProvider;
use Notify, ContextualLinks, Blocks;

class AdminPageController extends ModelController
{
	use JsGridController;

	/**
	 * Stores a new page, model must be set within the route
	 * @param  Request $request
	 * @return redirect
	 */
	public function store(Request $request)
	{
		$modelStr = $this->checkIfRouteHasModel($request);
		$model = new $modelStr;
		$validator = $model->makeValidator($request, $model->addFormFields());
		$validator->after(function($validator){
			$slug = $validator->getData()['slug'];
			if(route_exists($slug)){
				$validator->errors()->add('slug', 'The route '.$slug.' already exists');
			}
		});
		$validator->validate();
		$validated = $validator->validated();

		try{
			$model->saveWithRelations($validated);
			Notify::put('success', $model::friendlyName().' has been saved');
		}
		catch(ModelNotSaved $e){
			Notify::put('info', 'Error while saving '.$model::friendlyName());
		}
		catch(ModelRelationsNotSaved $e){
			Notify::put('info', $model::friendlyName().' was partially saved, check manually');
		}

		return back();
	}

	public function listBlocks(Request $request)
	{
		$page = $request->route('Page');
		$providers = BlockProvider::where('system', 0)->get();
		ContextualLinks::addLinks($page->getContextualLinks());
		return view('page::page_blocks')->with([
			'page' => $page,
			'layout' => $page->page_layout,
			'regions' => $page->page_layout->regions,
			'providers' => Blocks::getByProvider()
		]);
	}
}
