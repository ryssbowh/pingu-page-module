<?php 

namespace Modules\Page\Traits;

use Modules\Page\Entities\Block;

trait BlockProvidable
{
	/**
	 * Which field references the generic block for this provider
	 * @return string
	 */
	public function getBlockField()
	{
		return 'block_id';
	}

	/**
	 * Get all blocks for this provider
	 * @return Collection
	 */
	public function getBlocks()
	{
		return $this->getBlockModel()::all();
	}

	/**
	 * Returns this provider's block associated with a given generic block
	 * @param  Block  $block
	 * @return Block
	 */
	public function loadBlock(Block $generic)
	{
		return $this->getBlockModel()::where($this->getBlockField(), $generic->id)->first();
	}
}