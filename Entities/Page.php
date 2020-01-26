<?php

namespace Pingu\Page\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Pingu\Block\Entities\Block;
use Pingu\Entity\Entities\Entity;
use Pingu\Field\Contracts\HasRevisionsContract;
use Pingu\Field\Traits\HasRevisions;
use Pingu\Page\Entities\Policies\PagePolicy;
use Pingu\Page\Exceptions\PageNotfoundException;
use Pingu\Permissions\Entities\Permission;

class Page extends Entity implements HasRevisionsContract
{
    use HasRevisions;
    
    protected $fillable = ['name', 'slug', 'layout'];

    protected $visible = ['id', 'name', 'slug', 'layout'];

    protected $casts = [
        'published' => 'bool'
    ];

    public $adminListFields = ['name', 'slug'];

    public static function boot()
    {
        parent::boot();

        static::deleted(
            function ($page) {
                foreach ($page->blocks as $block) {
                    $block->delete();
                }
                \Pages::clearBlockCache($page);
                \Pages::clearPageCache($page);
            }
        );
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPermissionAttribute()
    {
        $value = $this->attributes['permission_id'] ?? null;
        return $value ? \Permissions::getById($value) : null;
    }

    /**
     * Permission relationship
     * 
     * @return BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * Find a block for this page by id
     * 
     * @param int $id
     * 
     * @return Block
     */
    public function findBlock(int $id): Block
    {
        return $this->blocks()->where('id', $id)->first();
    }

    /**
     * Next block weight for this page
     * 
     * @return int
     */
    public function getNextBlockWeight(): int
    {
        $biggest = $this->blocks->last();
        return $biggest ? $biggest->pivot->weight + 1 : 0;
    }

    public function getPolicy(): string
    {
        return PagePolicy::class;
    }

    public static function findBySlug(string $slug)
    {
        $page = static::where(['slug' => $slug])->first();
        if (!$page) {
            throw new PageNotfoundException($slug);
        }
        return $page;
    }

    /**
     * Blocks relationship
     * 
     * @return BelongsToMany
     */
    public function blocks()
    {
        return $this->belongsToMany(Block::class)->withTimestamps()->withPivot('weight')->orderBy('weight', 'asc');
    }
}
