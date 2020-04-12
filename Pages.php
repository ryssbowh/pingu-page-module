<?php

namespace Pingu\Page;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Block\Entities\Block;
use Pingu\Page\Entities\Page;
use Pingu\Page\Http\Controllers\PageWebController;

class Pages
{
    protected $pages;

    /**
     * Get a page's blocks from cache
     * 
     * @param Page $page
     * 
     * @return Collection
     */
    public function blocks(Page $page, $checkPerms = false): Collection
    {
        $blocks = $this->allBlocks($page);

        if (!$checkPerms) {
            return $blocks;
        }
        $role = \Permissions::getPermissionable();
        return $blocks->filter(
            function ($block) use ($role) {
                $perm = $block->permission;
                return ((is_null($perm) or $role->hasPermissionTo($perm)) and $block->active);
            }
        );
    }

    /**
     * Registers all pages in laravel route system
     */
    public function registerRoutes()
    {
        foreach ($this->all() as $page) {
            \Route::get($page->slug, ['uses' => PageWebController::class.'@view'])
                ->name('pages.'.$page->machineName)
                ->middleware('web');
        }
    }

    /**
     * get all pages
     * 
     * @return Collection
     */
    public function all(): Collection
    {
        if (is_null($this->pages)) {
            $this->pages = \ArrayCache::rememberForever(
                config('page.cache-keys.pages'), 
                function () {
                    return Page::all();
                }
            );
        }
        return $this->pages;
    }

    /**
     * Get all blocks for a page
     * 
     * @param Page $page
     * 
     * @return Collection
     */
    public function allBlocks(Page $page): Collection
    {
        return \ArrayCache::rememberForever(
            config('page.cache-keys.blocks').'.'.$page->id, function () use ($page) {
                return $page->blocks;
            }
        );
    }

    /**
     * Get a block for a page by id
     * 
     * @param Page $page
     * @param int  $id
     * 
     * @return ?Block
     */
    public function block(Page $page, int $id): ?Block
    {
        $blocks = $this->blocks($page);
        return $blocks->where('id', $id)->first();
    }

    /**
     * Clears one page's block cache
     * 
     * @param Page $page
     */
    public function clearBlockCache(Page $page)
    {
        \ArrayCache::forget(config('page.cache-keys.blocks').'.'.$page->id);
    }

    /**
     * Clears all pages block cache
     */
    public function clearAllBlockCache()
    {
        \ArrayCache::forget(config('page.cache-keys.blocks'));
    }

    /**
     * Clears all page cache
     */
    public function clearPageCache()
    {
        \ArrayCache::forget(config('page.cache-keys.pages'));
        if (app()->routesAreCached()) {
            \Artisan::call('route:cache');
        }
    }
}