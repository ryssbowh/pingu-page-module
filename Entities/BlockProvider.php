<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Page\Entities\Block;

class BlockProvider extends BaseModel
{
    protected $fillable = [];
    protected $visible = ['id', 'class', 'block_class', 'system', 'name'];

    public function blocks()
    {
    	return $this->hasMany(Block::class);
    }
}
