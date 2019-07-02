<?php
namespace Pingu\Page\Facades;

use Illuminate\Support\Facades\Facade;

class Blocks extends Facade {

	protected static function getFacadeAccessor() {

		return 'page.blocks';

	}

}