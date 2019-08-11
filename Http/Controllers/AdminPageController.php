<?php

namespace Pingu\Page\Http\Controllers;

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
	public function editBlocks(Page $page)
	{
		\ContextualLinks::addModelLinks($page);
		return view('page::page_blocks')->with([
			'page' => $page,
			'regions' => $page->regions,
			'blocks' => \Blocks::bySection(),
			'creators' => \BlockCreator::getModels(),
			'listBlocksUri' => Page::transformUri('listBlocks', $page, config('core.ajaxPrefix')),
			'patchUrl' => Page::transformUri('patchBlocks', $page, config('core.ajaxPrefix'))
		]);
	}

	public function editLayout(Page $page)
	{
		\ContextualLinks::addModelLinks($page);
		return view('page::page_layout')->with([
			'regions' => $page->regions,
			'page' => $page,
			'addRegionUri' => PageRegion::transformUri('create', $page, config('core.ajaxPrefix')),
			'saveRegionUri' => PageRegion::transformUri('patch', $page, config('core.ajaxPrefix')),
			'deleteRegionUri' => PageRegion::getUri('delete', config('core.ajaxPrefix'))
		]);
	}
}
