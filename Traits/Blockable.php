<?php

namespace Modules\Page\Traits;

use Modules\Page\Entities\Block;

trait Blockable
{

	/**
	 * Get the generic block
	 * @return Relation
	 */
	public function block()
    {
    	return $this->hasOne(Block::class);
    }

}