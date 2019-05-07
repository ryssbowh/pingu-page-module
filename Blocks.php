<?php

namespace Pingu\Page;
use Cache, Route;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\Page;

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