<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;

class PageBlock extends BaseModel
{
    protected $fillable = [];

    public function regions()
    {
    	return $this->belongsToMany("Modules\Page\Entities\PageRegion")->withPivot('page_region_id');
    }
}
