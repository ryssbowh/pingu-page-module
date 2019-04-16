<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ModelController;
use Modules\JsGrid\Http\Controllers\JsGridController;

class AdminController extends ModelController
{
	use JsGridController;
}
