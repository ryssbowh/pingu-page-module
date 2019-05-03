<?php
namespace Modules\Page\Facades;

use Illuminate\Support\Facades\Facade;

class Pages extends Facade {

	protected static function getFacadeAccessor() {

		return 'page.pages';

	}

}