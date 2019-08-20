<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Forms\Support\Form;
use Pingu\Page\Entities\Page;

class AjaxRegionController extends AjaxModelController
{
	use RegionController;

	/**
	 * @inheritDoc
	 */
	protected function afterCreateFormCreated(Form $form)
	{
		parent::afterCreateFormCreated($form);
		$page = $this->request->route()->parameter(Page::routeSlug());
		$form->setFieldValue('page', $page->id);
	}
}
