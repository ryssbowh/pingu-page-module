<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\Models\HasRouteSlugContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Page\Entities\Block;

class BlockProvider extends BaseModel implements HasRouteSlugContract
{
    protected $fillable = [];
    
    protected $visible = ['id', 'class', 'block_class', 'system', 'name'];

    public static function routeSlug(){
    	return 'provider';
    }

    public static function routeSlugs(){
    	return 'provider';
    }

    public function blocks()
    {
    	return $this->hasMany(Block::class, 'provider_id');
    }
}
