<?php

namespace Modules\Page\Contracts;

interface BlockableContract
{
	/**
	 * Defines block relationship
	 * @return Illuminate\Database\Eloquent\Relations\Relation
	 */
	public function block();
}