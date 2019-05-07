<?php

namespace Pingu\Page\Entities;

use Pingu\Page\Entities\PageRegion;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\APIableModel;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\Traits\Formable;
use Pingu\Jsgrid\Contracts\JsGridableContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\JsGridable;
use Pingu\Page\Entities\Page;

class PageLayout extends BaseModel implements
    JsGridableContract
{
    use JsGridable, Formable, APIableModel;

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
