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
     * Get all pages from Cache
     * 
     * @return Collection
     */
    public function pages(): Collection
    {
        return \ArrayCache::rememberForever(
            $this->pageCacheKey, function () {
                return $this->migrated ? Page::all() : collect();
            }
        );
    }

    /**
     * Get a page's blocks from cache
     * 
     * @param Page $page
     * 
     * @return Collection
     */
    public function blocks(Page $page, $checkPerms = false): Collection
    {
        $blocks = \ArrayCache::rememberForever(
            $this->blocksCacheKey.'.'.$page->id, function () use ($page) {
                return $page->blocks;
            }
        );
        if (!$checkPerms) {
            return $blocks;
        }
        $role = \Permissions::getPermissionableModel();
        return $blocks->filter(
            function ($block) use ($role) {
                $perm = $block->permission;
                return ((is_null($perm) or $role->hasPermissionTo($perm)) and $block->active);
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
        \ArrayCache::forget($this->blocksCacheKey.'.'.$page->id);
    }

    /**
     * Clears all pages block cache
     */
    public function clearAllBlockCache()
    {
        \ArrayCache::forget($this->blocksCacheKey);
    }

    /**
     * Clears all page cache
     */
    public function clearPageCache()
    {
        \ArrayCache::forget($this->pageCacheKey);
    }
}