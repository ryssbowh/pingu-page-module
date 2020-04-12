<?php 

namespace Pingu\Page\Observers;

use Pingu\Page\Entities\Page;

class PageObserver
{
    public function created(Page $page)
    {
        \Pages::clearPageCache();
    }

    public function deleted(Page $page)
    {
        foreach ($page->blocks as $block) {
            $block->delete();
        }
        \Pages::clearBlockCache($page);
        \Pages::clearPageCache();
    }

    public function updated(Page $page)
    {
        \Pages::clearPageCache();
    }
}