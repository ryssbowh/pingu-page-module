<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\Models\HasAdminRoutesContract;
use Pingu\Core\Contracts\Models\HasAjaxRoutesContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasAdminRoutes;
use Pingu\Core\Traits\Models\HasAjaxRoutes;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\PageRegion;

class Block extends BaseModel implements HasAdminRoutesContract, HasAjaxRoutesContract
{
    use HasAdminRoutes, HasAjaxRoutes, HasRouteSlug;

    protected $fillable = [];

    protected $with = ['instance', 'provider'];

    protected $visible = ['id', 'system', 'instance', 'provider'];

    public function regions()
    {
    	return $this->hasMany(PageRegion::class);
    }

    public function provider()
    {
    	return $this->belongsTo(BlockProvider::class);
    }

    public function instance()
    {
        return $this->morphTo();
    }

    public static function adminIndexUri()
    {
        return Page::routeSlug().'/{'.Page::routeSlug().'}/'.static::routeSlugs();
    }

    public static function ajaxCreateUri()
    {
        return static::routeSlugs().'/{'.BlockProvider::routeSlug().'}/create';
    }

    public static function ajaxStoreUri()
    {
        return static::routeSlugs().'/{'.BlockProvider::routeSlug().'}';
    }

    public static function ajaxIndexUri()
    {
        return Page::routeSlug().'/{'.Page::routeSlug().'}/'.static::routeSlugs();
    }
}
