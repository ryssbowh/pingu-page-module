<?php

namespace Pingu\Page;

use Illuminate\Support\Collection;
use Pingu\Block\Entities\Block;
use Pingu\Page\Entities\Page;

class Pages
{
    protected $migrated = false;
    protected $pageCacheKey = 'page.pages';
    protected $blocksCacheKey = 'page.blocks';

    public function __construct()
    {
        $this->migrated = \Schema::hasTable('pages');
    }

    /**
     * Load all pages routes
     * @return void
     */
    public function loadRoutes()
    {
        $pages = $this->getPages();
        if (!$pages->isEmpty()) {
            foreach ($pages as $page) { 
                \Route::get('/{'.$page->slug.'}', ['uses' => '\Pingu\Page\Http\Controllers\DbPageController@show']);
            }
        }
    }

    /**
     * Get all pages from Cache
     * @return Collection
     */
    public function getPages(): Collection
    {
        return \ArrayCache::rememberForever($this->pageCacheKey, function () {
            return $this->migrated ? Page::all() : collect();
        });
    }

    public function blocks(Page $page): Collection
    {
        return \ArrayCache::rememberForever($this->blocksCacheKey.'.'.$page->id, function () use ($page) {
            return $page->blocks;
        });
    }

    public function block(Page $page, int $id): ?Block
    {
        $blocks = $this->blocks($page);
        return $blocks->where('id', $id)->first();
    }

    public function clearBlockCache(Page $page)
    {
        \ArrayCache::forget($this->blocksCacheKey.'.'.$page->id);
    }

    public function clearAllBlockCache()
    {
        \ArrayCache::forget($this->blocksCacheKey);
    }

    public function clearPageCache()
    {
        \ArrayCache::forget($this->pageCacheKey);
    }
}