<?php

namespace Pingu\Page\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Pingu\Block\Entities\Block;
use Pingu\Core\Contracts\RendererContract;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Core\Traits\RendersWithRenderer;
use Pingu\Entity\Support\Entity;
use Pingu\Field\Contracts\HasRevisionsContract;
use Pingu\Field\Traits\HasRevisions;
use Pingu\Page\Entities\Policies\PagePolicy;
use Pingu\Page\Renderers\PageRenderer;
use Pingu\Permissions\Entities\Permission;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Page extends Entity implements HasRevisionsContract
{
    use HasRevisions, HasMachineName, RendersWithRenderer;
    
    protected $fillable = ['name', 'slug', 'layout', 'published', 'machineName'];

    protected $visible = ['id', 'name', 'slug', 'layout', 'published', 'machineName'];

    protected $casts = [
        'published' => 'bool'
    ];

    public $adminListFields = ['name', 'slug'];

    protected $attributes = [
        'published' => true
    ];

    public $descriptiveField = 'name';

    /**
     * @inheritDoc
     */
    public function systemView(): string
    {
        return 'page@page';
    }

    /**
     * @inheritDoc
     */
    public function viewIdentifier(): string
    {
        return 'page';
    }

    /**
     * Slug mutator
     * 
     * @param string $slug
     */
    public function setSlugAttribute(string $slug)
    {
        $this->attributes['slug'] = trim($slug, '/');
    }

    /**
     * @inheritDoc
     */
    public function getRenderer(): RendererContract
    {
        return new PageRenderer($this);
    }

    /**
     * @inheritDoc
     */
    public function getRouteKeyName()
    {
        return 'machineName';
    }

    /**
     * Permission accessor
     * 
     * @return ?Permission
     */
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

    /**
     * @inheritDoc
     */
    public function getPolicy(): string
    {
        return PagePolicy::class;
    }

    /**
     * Find a page by its slug
     * 
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * 
     * @return Page
     */
    public static function findBySlug(string $slug)
    {
        $page = static::where(['slug' => $slug])->first();
        if (!$page) {
            throw new NotFoundHttpException;
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
