<?php

namespace Modules\Page\BlockProviders;

use Modules\Page\Contracts\BlockProviderContract;
use Modules\Page\Entities\BlockText;
use Modules\Page\Traits\BlockProvidable;

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