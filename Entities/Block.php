<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\AjaxableModel as AjaxableModelContract;
use Pingu\Core\Contracts\AdminableModel as AdminableModelContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\AjaxableModel;
use Pingu\Core\Traits\AdminableModel;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\PageRegion;

class Block extends BaseModel implements AdminableModelContract, AjaxableModelContract
{
    use AdminableModel, AjaxableModel;

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
