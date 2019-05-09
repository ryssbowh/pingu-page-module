<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Contracts\ModelController as ModelControllerContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ModelController;
use Pingu\Jsgrid\Contracts\JsGridController as JsGridControllerContract;
use Pingu\Jsgrid\Traits\JsGridController;
use Pingu\Page\Entities\PageLayout;


class LayoutController extends BaseController implements ModelControllerContract, JsGridControllerContract
{
	use JsGridController, ModelController;

	public function getModel():string
	{
		return PageLayout::class;
	}
}
