<?php

namespace Pingu\Page\Renderers;

use Illuminate\Support\Collection;
use Pingu\Core\Support\Renderers\ObjectRenderer;
use Pingu\Forms\Support\ClassBag;
use Pingu\Page\Entities\Page;

class PageRenderer extends ObjectRenderer
{
    public function __construct(Page $page)
    {
        parent::__construct($page);
    }

    /**
     * @inheritDoc
     */
    public function viewFolder(): string
    {
        return 'pages';
    }

    /**
     * @inheritDoc
     */
    public function getHookName(): string
    {
        return 'page';
    }

    /**
     * @inheritDoc
     */
    public function getDefaultData(): Collection
    {
        $blocks = $this->object->blocks->map(function($block){
            return $block->instance();
        });
        return collect([
            'page' => $this->object,
            'classes' => new ClassBag(['page', 'page-'.$this->object->machineName]),
            'blocks' => $blocks
        ]);
    }
}