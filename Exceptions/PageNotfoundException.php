<?php

namespace Pingu\Page\Exceptions;

class PageNotfoundException extends \Exception{

	public function __construct(string $slug)
	{
		parent::__construct($slug." is not a valid page");
	}

}