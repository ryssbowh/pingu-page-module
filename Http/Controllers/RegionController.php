<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Entities\BaseModel;
use Pingu\Forms\Support\Form;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

trait RegionController
{
	protected function getModel()
	{
		return PageRegion::class;
	}

	/**
	 * @inheritDoc
	 */
	protected function getStoreUri()
	{
		$page = $this->request->route()->parameter(Page::routeSlug());
		return PageRegion::makeUri('store', [$page], adminPrefix());
	}

	/**
	 * @inheritDoc
	 */
	protected function afterCreateFormCreated(Form $form)
	{
		$page = $this->request->route()->parameter(Page::routeSlug());
		$form->setFieldValue('page', $page->id);
	}
}
