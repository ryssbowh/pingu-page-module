<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;
use Modules\Page\Entities\BlockProvider;
use Modules\Page\Entities\PageRegion;

class Block extends BaseModel
{
    protected $fillable = [];

    public function regions()
    {
    	return $this->hasMany(PageRegion::class);
    }

    public function block_provider()
    {
    	return $this->hasOne(BlockProvider::class);
    }

    public function loadBlock()
    {
    	return $this->provider->class::getBlock($this->id);
    }
}
