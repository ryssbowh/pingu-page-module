<?php

namespace Pingu\Page\Entities\Routes;

use Pingu\Block\Entities\Block;
use Pingu\Entity\Support\Routes\BaseEntityRoutes;
use Pingu\Page\Http\Controllers\DbPageController;

class PageRoutes extends BaseEntityRoutes
{
    protected $inheritsEntityRoutes = false;

    /**
     * @inheritDoc
     */
    protected function routes(): array
    {
        return [
            'admin' => [
                'index', 'create', 'store', 'edit', 'update', 'patch', 'confirmDelete', 'delete', 'content', 'deleteBlock'
            ],
            'ajax' => [
                'index', 'view', 'create', 'store', 'edit', 'update', 'patch', 'delete', 'addBlock', 'patchBlocks', 'deleteBlock'
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    protected function middlewares(): array
    {
        return [
            'content' => 'can:view,@slug',
            'patchBlocks' => 'can:edit,@slug',
            'addBlock' => 'can:edit,@slug',
            'deleteBlock' => 'can:edit,@slug'
        ];
    }

    /**
     * @inheritDoc
     */
    protected function methods(): array
    {
        return [
            'patchBlocks' => 'patch',
            'addBlock' => 'post',
            'deleteBlock' => 'delete'
        ];
    }
}