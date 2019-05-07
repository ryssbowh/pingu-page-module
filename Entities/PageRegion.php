<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\APIableModel;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\Traits\Formable;
use Pingu\Jsgrid\Contracts\JsGridableContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\JsGridable;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\PageLayout;

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
