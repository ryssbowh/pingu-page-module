<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Validation\Validator;
use Pingu\Block\Entities\Block;
use Pingu\Block\Entities\BlockProvider;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AdminModelController;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class AdminPageController extends AdminModelController
{
	public function getModel()
	{
		return Page::class;
	}

	/**
	 * @inheritDoc
	 */
	public function modifyStoreValidator(Validator $model)
	{
		$validator->after(function($validator){
			$slug = $validator->getData()['slug'];
			if(route_exists($slug)){
				$validator->errors()->add('slug', 'The route '.$slug.' already exists');
			}
		});
	}

	public function blocks(Page $page)
	{
		\ContextualLinks::addModelLinks($page);
		return view('page::page_blocks')->with([
			'page' => $page,
			'regions' => $page->regions,
			'blocks' => \Blocks::bySection(),
			'creators' => \BlockCreator::getModels(),
			'listBlocksUri' => Page::makeUri('blocks', $page, ajaxPrefix()),
			'patchUrl' => Page::makeUri('patchBlocks', [], ajaxPrefix()),
			'blockClass' => Block::class
		]);
	}
	
}
