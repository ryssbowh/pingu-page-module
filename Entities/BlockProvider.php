<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;
use Modules\Page\Entities\Block;

class BlockProvider extends BaseModel
{
    protected $fillable = [];
    protected $visible = ['id', 'class', 'block_class', 'system', 'name'];

    public function blocks()
    {
    	return $this->hasMany(Block::class);
    }
}
