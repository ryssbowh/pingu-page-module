<?php

namespace Pingu\Page\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Pingu\Block\Entities\Block;
use Pingu\Entity\Entities\Entity;
use Pingu\Page\Entities\Policies\PagePolicy;
use Pingu\Page\Exceptions\PageNotfoundException;

class Page extends Entity
{
    protected $fillable = ['name', 'slug', 'layout'];

    protected $visible = ['id', 'name', 'slug', 'layout'];

    protected $with = [];

    public $adminListFields = ['name', 'slug'];

    public static function boot()
    {
        parent::boot();

        static::deleted(function ($page) {
            foreach ($page->blocks as $block) {
                $block->delete();
            }
        });
    }

    public function findBlock($id): Block
    {
        return $this->blocks()->where('id', $id)->first();
    }

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
