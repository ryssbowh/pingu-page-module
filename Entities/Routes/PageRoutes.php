<?php

namespace Pingu\Page\Entities\Routes;

use Pingu\Block\Entities\Block;
use Pingu\Entity\Support\BaseEntityRoutes;

class PageRoutes extends BaseEntityRoutes
{
    protected function routes(): array
    {
        return [
            'admin' => ['content'],
            'ajax' => ['blocks', 'addBlock','patchBlocks']
        ];
    }

    protected function middlewares(): array
    {
        return [
            'admin.content' => 'can:view,@slug',
            'ajax.blocks' => 'can:view,@slug',
            'ajax.patchBlocks' => ['can:edit,@slug','can:edit,'.Block::routeSlug()],
            'ajax.addBlock' => ['can:edit,@slug','can:create,'.Block::routeSlug()]
        ];
    }

    protected function methods(): array
    {
        return [
            'patchBlocks' => 'patch',
            'addBlock' => 'post'
        ];
    }

    protected function names(): array
    {
        return [
            'admin.index' => 'page.admin.pages'
        ];
    }
}