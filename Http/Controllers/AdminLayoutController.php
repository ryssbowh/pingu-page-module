<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Http\Controllers\AdminModelController;
use Pingu\Page\Entities\PageLayout;

class AdminLayoutController extends AdminModelController
{
	public function getModel():string
	{
		return PageLayout::class;
	}
}
