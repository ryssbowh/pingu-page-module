<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;
use Modules\Core\Traits\APIableModel;
use Modules\Forms\Fields\Text;
use Modules\Forms\Traits\Formable;
use Modules\Jsgrid\Contracts\JsGridableContract;
use Modules\Jsgrid\Fields\Text as JsGridText;
use Modules\Jsgrid\Traits\JsGridable;
use Modules\Page\Entities\Block;
use Modules\Page\Entities\PageLayout;

class PageRegion extends BaseModel implements
    JsGridableContract
{
	use JsGridable, Formable, APIableModel;

    protected $fillable = ['name', 'width', 'height'];
    protected $visible = ['id','name','width','height'];

    public static function friendlyName()
    {
        return 'Region';
    }

    public function page_layout()
    {
    	return $this->belongsTo(PageLayout::class);
    }

    public function blocks(){
    	return $this->belongsToMany(Block::class)->withTimestamps()->withPivot('weight');
    }

    public function getBlocks()
    {
        return $this->blocks()->orderBy('weight','asc')->get();
    }

    public static function jsGridFields()
    {
    	return [
    		'name' => [
                'type' => JsGridText::class
            ]
    	];
    }

    public static function fieldDefinitions()
    {
        return [
            'name' => [
                'type' => Text::class,
                'label' => 'Name'
            ]
        ];
    }

    public function validationRules()
    {
        return [
            'name' => 'required'
        ];
    }
}
