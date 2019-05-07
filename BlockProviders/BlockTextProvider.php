<?php

namespace Pingu\Page\BlockProviders;

use Pingu\Page\Contracts\BlockProviderContract;
use Pingu\Page\Entities\BlockText;
use Pingu\Page\Traits\BlockProvidable;

class BlockTextProvider implements BlockProviderContract
{
	use BlockProvidable;

	/**
	 * returns the model associated with this block provider
	 * @return string
	 */
	public function getBlockModel(){
		return BlockText::class;
	}
}