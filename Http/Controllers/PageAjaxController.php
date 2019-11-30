<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Block\Entities\Block;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class PageAjaxController extends BaseController
{
    public function addBlock(Page $page, Block $block)
    {
        $weight = $page->getNextBlockWeight();
        $page->blocks()->attach($block, ['weight' => $weight]);
        \Pages::clearBlockCache($page);
        return ['success' => true];
    }

    public function deleteBlock(Page $page, Block $block)
    {
        $page->blocks()->detach($block);
        $block->delete();
        \Pages::clearBlockCache($page);
        return ['success' => true];
    }

    public function patchBlocks(Page $page)
    {
        $blocks = $this->request->post()['blocks'];
        foreach ($blocks as $blockId => $attributes) {
            $block = \Pages::block($page, $blockId);
            $block->pivot->weight = $attributes['weight'];
            if (isset($attributes['active'])) {
                $block->active = true;
            }
            $block->save();
        }
        \Pages::clearBlockCache($page);

        return ['message' => 'Blocks have been saved'];
    }

    public function blocks(Page $page)
    {
        return \Pages::blocks($page);
    }
}