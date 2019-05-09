<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\ApiModelController;
use Pingu\Core\Contracts\ApiModelController as ApiModelControllerContract;
use Pingu\Page\Entities\Page;

class ApiPageController extends BaseController implements ApiModelControllerContract
{
	use ApiModelController;

	public function getModel(): string
	{
		return Page::class;
	}
}