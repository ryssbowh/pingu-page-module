<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Page\Entities\BlockProvider;
use Pingu\Page\Entities\PageRegion;

class Block extends BaseModel
{
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
}
