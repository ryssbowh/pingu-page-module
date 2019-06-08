<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Contracts\Controllers\HandlesAjaxModelContract;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\Controllers\HandlesAjaxModel;
use Pingu\Page\Entities\PageLayout;

class AjaxLayoutController extends BaseController implements HandlesAjaxModelContract
{
    use HandlesAjaxModel;
	
	public function getModel(): string
	{
		return PageLayout::class;
	}
}