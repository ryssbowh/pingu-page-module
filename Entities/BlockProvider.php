<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;

class BlockProvider extends BaseModel
{
    protected $fillable = [];
    protected $visible = ['id', 'class', 'block_class', 'system', 'name'];
}
