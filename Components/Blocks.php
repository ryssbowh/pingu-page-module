<?php

namespace Modules\Page\Components;
use Cache, Route;
use Modules\Page\Entities\BlockProvider;
use Modules\Page\Entities\Page;

class Blocks{

	public function getByProvider()
	{
		$out = [];
		foreach(BlockProvider::all() as $provider){
			$array = $provider->toArray();
			$array['blocks'] = (new $provider->class)->getBlocks();
			$out[] = $array;
		}
		return $out;
	}

}