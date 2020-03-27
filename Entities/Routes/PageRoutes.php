<?php

namespace Pingu\Page\Entities\Routes;

use Pingu\Block\Entities\Block;
use Pingu\Entity\Support\Routes\BaseEntityRoutes;
use Pingu\Page\Http\Controllers\DbPageController;

class PageRoutes extends BaseEntityRoutes
{
    /**
     * @inheritDoc
     */
    protected function routes(): array
    {
        return [
            'admin' => ['content'],
            'ajax' => ['blocks', 'addBlock','patchBlocks']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function middlewares(): array
    {
        return [
            'content' => 'can:view,@slug',
            'blocks' => 'can:view,@slug',
            'patchBlocks' => ['can:edit,@slug','can:edit,'.Block::routeSlug()],
            'addBlock' => ['can:edit,@slug','can:create,'.Block::routeSlug()],
            'view' => ['can:view,@slug', 'published:@slug']
        ];
    }

    /**
     * @inheritDoc
     */
    protected function methods(): array
    {
        return [
            'patchBlocks' => 'patch',
            'addBlock' => 'post'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function controllers(): array
    {
        return [
            'web.view' => DbPageController::class
        ];
    }

    /**
     * @inheritDoc
     */
    protected function names(): array
    {
        return [
            'admin.index' => 'page.admin.pages'
        ];
    }
}