<?php

namespace Modules\Page\Traits;

use Modules\Page\Entities\PageBlock;

trait Blockable
{
	public function getBlockEntity()
	{
		return PageBlock::where(['class' => get_class($this), 'id' -> $this->id]);
	}
}