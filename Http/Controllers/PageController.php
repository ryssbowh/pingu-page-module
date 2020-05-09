<?php

namespace Pingu\Page\Http\Controllers;

use Pingu\Block\Entities\Block;
use Pingu\Core\Traits\Controllers\RendersAdminViews;
use Pingu\Entity\Http\Controllers\EntityCrudContextController;
use Pingu\Page\Entities\Page;

class PageController extends EntityCrudContextController
{
    use RendersAdminViews;

    public function content(Page $page)
    {
        \ContextualLinks::addObjectActions($page);
        return $this->renderAdminView(
            'pages.page.content',
            'page-content',
            [
                'page' => $page,
                'blocks' => \Blocks::registeredBlocksBySection(),
                'blockModel' => Block::class,
                'saveBlocksUri' => Page::uris()->make('patchBlocks', $page, adminPrefix())
            ]
        );
    }

    /**
     * Add a block to a page
     * 
     * @param Page  $page 
     * @param Block $block
     *
     * @return array
     */
    public function addBlock(Page $page, Block $block)
    {
        $weight = $page->getNextBlockWeight();
        $page->blocks()->attach($block, ['weight' => $weight]);
        \Pages::clearBlockCache($page);
        return ['success' => true];
    }

    /**
     * Deletes a block from a page
     *
     * @param Page   $page
     * @param Block  $block
     * 
     * @return array
     */
    public function deleteBlock(Page $page, Block $block)
    {
        $page->blocks()->detach($block);
        $block->delete();
        \Pages::clearBlockCache($page);
        return ['success' => true];
    }

    /**
     * Saves page's blocks
     * 
     * @param Page $page
     * 
     * @return array
     */
    public function patchBlocks(Page $page)
    {
        $blocks = $this->request->post()['blocks'];
        foreach ($blocks as $attributes) {
            $block = \Pages::block($page, $attributes['id']);
            if (!$block) {
                continue;
            }
            $block->pivot->weight = $attributes['weight'];
            $block->pivot->save();
        }
        \Pages::clearBlockCache($page);

        return ['message' => 'Blocks have been saved'];
    }

    /**
     * @inheritDoc
     */
    public function view(Request $request)
    {
        $page = Page::findBySlug($request->path());
        if (!\Gate::check('view', $page)) {
            throw new NotFoundHttpException;
        }
        if (!$page->published) {
            \Notify::warning('This page is not published');
        }
        return $page->render();
    }
}