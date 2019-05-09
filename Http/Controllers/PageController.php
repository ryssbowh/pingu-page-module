<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Notify, ContextualLinks, Blocks;
use Pingu\Core\Contracts\ModelController as ModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ModelController;
use Pingu\Forms\Contracts\FormableModel;
use Pingu\Jsgrid\Contracts\JsGridController as JsGridControllerContract;
use Pingu\Jsgrid\Traits\JsGridController;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;

class PageController extends BaseController implements ModelControllerContract, JsGridControllerContract
{
	use JsGridController, ModelController;

	public function getModel():string
	{
		return Page::class;
	}

	public function validateStoreModelRequest(Request $request, FormableModel $model)
	{
		$validator = $model->makeValidator($request, $model->addFormFields());
		$validator->after(function($validator){
			$slug = $validator->getData()['slug'];
			if(route_exists($slug)){
				$validator->errors()->add('slug', 'The route '.$slug.' already exists');
			}
		});
		$validator->validate();
		return $validator->validated();
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
