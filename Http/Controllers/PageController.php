<?php

namespace Pingu\Page\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Notify, ContextualLinks, Blocks;
use Pingu\Core\Contracts\ModelController as ModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ModelController;
use Pingu\Forms\Contracts\FormableModel;
use Pingu\Jsgrid\Contracts\JsGridController as JsGridControllerContract;
use Pingu\Jsgrid\Traits\JsGridController;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;

class PageController extends BaseController implements ModelControllerContract, JsGridControllerContract
{
	use JsGridController, ModelController;

	public function getModel():string
	{
		return Page::class;
	}

	public function validateStoreRequest(Request $request, FormableModel $model)
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

	public function listBlocks(Request $request, Page $page)
	{
		ContextualLinks::addModelLinks($page);
		return view('page::page_blocks')->with([
			'page' => $page,
			'layout' => $page->page_layout,
			'regions' => $page->page_layout->regions,
			'providers' => BlockProvider::all(),
			'blockClass' => "Pingu\Page\Entities\Block",
			'blockIndexUri' => Block::transformAjaxUri('index', [$page->id], true)
		]);
	}

	/**
     * @inheritDoc
     */
    protected function canClick()
    {
    	return Auth::user()->can('edit pages');
    }

    /**
     * @inheritDoc
     */
    protected function canEdit()
    {
        return $this->canClick();
    }

    /**
     * @inheritDoc
     */
    protected function canDelete()
    {
    	return Auth::user()->can('delete pages');
    }

    /**
     * @inheritDoc
     */
	public function index(Request $request)
	{
		$options['jsgrid'] = $this->buildJsGridView($request);
		$options['title'] = str_plural(Page::friendlyName());
		$options['canSeeAddLink'] = Auth::user()->can('add pages');
		$options['addLink'] = '/admin/'.Page::routeSlugs().'/create';
		
		return view('pages.listModel-jsGrid', $options);
	}
}
