<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AdminModelController;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;

class AdminPageController extends AdminModelController
{
	public function getModel()
	{
		return Page::class;
	}

	/**
	 * @inheritDoc
	 */
	public function validateStoreRequest(BaseModel $model)
	{
		$validator = $model->makeValidator($this->request->post(), $model->getAddFormFields(), false);
		$validator->after(function($validator){
			$slug = $validator->getData()['slug'];
			if(route_exists($slug)){
				$validator->errors()->add('slug', 'The route '.$slug.' already exists');
			}
		});
		$validator->validate();
		return $validator->validated();
	}

	/**
	 * @inheritDoc
	 */
	public function listBlocks(Page $page)
	{
		\ContextualLinks::addModelLinks($page);
		return view('page::page_blocks')->with([
			'page' => $page,
			'layout' => $page->page_layout,
			'regions' => $page->page_layout->regions,
			'providers' => BlockProvider::all(),
			'blockClass' => "Pingu\Page\Entities\Block",
			'blockIndexUri' => Block::transformAjaxUri('index', [$page], true)
		]);
	}
}
