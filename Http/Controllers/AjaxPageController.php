<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\AjaxModelController;
use Pingu\Core\Contracts\AjaxModelController as AjaxModelControllerContract;
use Pingu\Page\Entities\Page;

class AjaxPageController extends BaseController implements AjaxModelControllerContract
{
	use AjaxModelController;

	public function getModel(): string
	{
		return Page::class;
	}
}