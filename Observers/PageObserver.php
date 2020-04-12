<?php 

namespace Pingu\Page\Observers;

use Pingu\Page\Entities\Page;

class PageObserver
{
    public function created(Page $page)
    {
        \Pages::clearPageCache();
        $this->rebuildRouteCache();
    }

    public function deleted(Page $page)
    {
        foreach ($page->blocks as $block) {
            $block->delete();
        }
        \Pages::clearBlockCache($page);
        \Pages::clearPageCache();
        $this->rebuildRouteCache();
    }

    public function saved(Page $page)
    {
        if ($page->wasChanged('slug')) {
            $this->rebuildRouteCache();
        }
    }

    protected function rebuildRouteCache()
    {
        if (app()->routesAreCached()) {
            \Artisan::call('route:cache');
        }
    }
}