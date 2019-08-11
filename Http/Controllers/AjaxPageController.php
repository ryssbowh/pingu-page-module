<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Block\Entities\Block;
use Pingu\Core\Http\Controllers\AjaxModelController;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class AjaxPageController extends AjaxModelController
{
	public function getModel()
	{
		return Page::class;
	}

	public function patchBlocks(): array
	{
		$regions = $this->request->post()['regions'];
		foreach($regions as $row){
			$region = PageRegion::findOrFail($row['region']);
			$region->blocks()->detach();
			if(isset($row['blocks'])){
				foreach($row['blocks'] as $weight => $id){
					$block = Block::findOrFail($id);
					$region->blocks()->attach($block, ['weight' => $weight]);
				}
			}
		}

		return ['message' => 'Blocks have been saved'];
	}

	public function listBlocks(Page $page): array
	{
		$regions = $page->regions;
		$out = [];
		foreach($regions as $region){
			foreach($region->blocks as $block){
				$out[$region->id][] = $block->toArray();
			}
		}
		return $out;
	}
}