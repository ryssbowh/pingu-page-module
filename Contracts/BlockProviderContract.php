<?php

namespace Modules\Page\Contracts;

use Modules\Page\Entities\Block;

interface BlockProviderContract
{
	/**
	 * returns the model associated with this block provider
	 * @return string
	 */
	public function getBlockModel();

	/**
	 * Which field references the generic block for this provider
	 * @return string
	 */
	public function getBlockField();

	/**
	 * Get all blocks for this provider
	 * @return Collection
	 */
	public function getBlocks();

	/**
	 * Returns this provider's block associated with a given generic block
	 * @param  Block  $block
	 * @return Block
	 */
	public function loadBlock(Block $block);
}