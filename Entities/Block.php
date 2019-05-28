<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\APIableModel as APIableModelContract;
use Pingu\Core\Contracts\AdminableModel as AdminableModelContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\APIableModel;
use Pingu\Core\Traits\AdminableModel;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\PageRegion;

class Block extends BaseModel implements AdminableModelContract, APIableModelContract
{
    use AdminableModel, APIableModel;

    protected $fillable = [];

    public function regions()
    {
    	return $this->hasMany(PageRegion::class);
    }

    public function block_provider()
    {
    	return $this->belongsTo(BlockProvider::class);
    }

    public function loadBlock()
    {
    	return (new $this->block_provider->class)->loadBlock($this);
    }

    public static function adminIndexUri()
    {
        return PageLayout::routeSlug().'/{'.PageLayout::routeSlug().'}/'.static::routeSlugs();
    }

    public static function apiCreateUri()
    {
        return static::routeSlugs().'/create/{'.BlockProvider::routeSlug().'}';
    }

    public static function apiIndexUri()
    {
        return Page::routeSlug().'/{'.Page::routeSlug().'}/'.static::routeSlugs();
    }

    public static function apiUpdateUri()
    {
        return static::apiIndexUri();
    }
}
