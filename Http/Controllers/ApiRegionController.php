<?php

namespace Pingu\Page\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Contracts\ApiModelController as ApiModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ApiModelController;
use Pingu\Forms\Contracts\FormableModel;
use Pingu\Forms\Form;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiRegionController extends BaseController implements ApiModelControllerContract
{
	use ApiModelController;

	public function getModel(): string
	{
		return PageRegion::class;
	}

	/**
	 * @inheritDoc
	 */
	protected function getStoreUri(Request $request): string
	{
		$layout = $request->route()->parameter(PageLayout::routeSlug());
		return PageRegion::transformApiUri('store', [$layout->id], true);
	}

	/**
	 * @inheritDoc
	 */
	public function afterStoreFormCreated(Request $request, Form $form)
	{
		$layout = $request->route()->parameter(PageLayout::routeSlug());
		$form->setFieldValue('page_layout', $layout);
	}

	/**
	 * @inheritDoc
	 */
	public function onDestroying(Request $request, FormableModel $model)
	{
		if(!$model->blocks->isEmpty()){
			throw new HttpException(422, 'this region has blocks associated to it, you can\'t delete it');
		}
	}
}
