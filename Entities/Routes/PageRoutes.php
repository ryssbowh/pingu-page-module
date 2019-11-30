<?php

namespace Pingu\Page\Entities\Routes;

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
            'admin.content' => 'can:editContent,@slug',
            'ajax.blocks' => 'can:editContent,@slug',
            'ajax.patchBlocks' => 'can:editContent,@slug',
            'ajax.addBlock' => 'can:editContent,@slug'
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