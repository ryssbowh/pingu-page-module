<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\APIableModel;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\Traits\FormableModel;
use Pingu\Jsgrid\Contracts\JsGridableModel as JsGridableModelContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\JsGridableModel;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class PageLayout extends BaseModel implements
    JsGridableModelContract
{
    use JsGridableModel, FormableModel, APIableModel;

    protected $fillable = ['name'];

    protected $visible = ['id', 'name'];

    public static function friendlyName()
    {
        return 'Layout';
    }

    public function pages()
    {
    	return $this->hasMany(Page::class);
    }

    public function regions(){
    	return $this->hasMany(PageRegion::class);
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
            'name' => 'required|unique:page_layouts,name,'.$this->id
        ];
    }

    public function getContextualLinks()
    {
        return [
            'edit' => [
                'title' => 'Edit',
                'url' => '/admin/'.$this::urlSegment().'/'.$this->id
            ],
            'regions' => [
                'model' => PageRegion::class,
                'title' => 'Regions',
                'url' => '/admin/'.$this::urlSegment().'/'.$this->id.'/'.PageRegion::urlSegments()
            ]
        ];
    }
}
