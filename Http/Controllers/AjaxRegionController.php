<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Forms\Support\Form;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AjaxRegionController extends AjaxModelController
{

	public function getModel()
	{
		return PageRegion::class;
	}

	/**
	 * @inheritDoc
	 */
	protected function getStoreUri()
	{
		$page = $this->request->route()->parameter(Page::routeSlug());
		return PageRegion::transformUri('store', [$page], config('core.ajaxPrefix'));
	}

	/**
	 * @inheritDoc
	 */
	protected function afterStoreFormCreated(Form $form)
	{
		$page = $this->request->route()->parameter(Page::routeSlug());
		$form->setFieldValue('page', $page->id);
	}

	/**
	 * @inheritDoc
	 */
	protected function beforeDestroying(BaseModel $model)
	{
		if(!$model->blocks->isEmpty()){
			throw new HttpException(422, 'this region has blocks associated to it, you can\'t delete it');
		}
	}
}
