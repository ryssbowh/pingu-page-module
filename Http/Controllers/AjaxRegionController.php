<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Forms\Support\Form;
use Pingu\Page\Entities\PageLayout;
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
		$layout = $this->request->route()->parameter(PageLayout::routeSlug());
		return PageRegion::transformAjaxUri('store', [$layout], true);
	}

	/**
	 * @inheritDoc
	 */
	protected function afterStoreFormCreated(Form $form)
	{
		$layout = $this->request->route()->parameter(PageLayout::routeSlug());
		$form->setFieldValue('page_layout', $layout->id);
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
