<?php

namespace Pingu\Page\Traits;

use Pingu\Page\Entities\Block;

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