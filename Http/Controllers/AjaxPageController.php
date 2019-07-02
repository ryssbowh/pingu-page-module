<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Page\Entities\Page;

class AjaxPageController extends AjaxModelController
{
	public function getModel()
	{
		return Page::class;
	}
}