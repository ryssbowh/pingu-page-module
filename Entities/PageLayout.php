<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;
use Modules\Core\Traits\APIableModel;
use Modules\Forms\Fields\Text;
use Modules\Forms\Traits\Formable;
use Modules\JsGrid\Contracts\JsGridableContract;
use Modules\JsGrid\Traits\JsGridable;
use Modules\JsGrid\Components\Text as JsGridText;
use Modules\Page\Entities\PageRegion;

class PageLayout extends BaseModel implements
    JsGridableContract
{
    use JsGridable, Formable, APIableModel;

    protected $fillable = ['name'];

    protected $visible = ['id', 'name'];

    public function pages()
    {
    	return $this->hasMany("Modules\Page\Entities\Page");
    }

    public function regions(){
    	return $this->hasMany("Modules\Page\Entities\PageRegion");
    }

    public static function jsGridFields()
    {
    	return [
    		'name' => ['type' => JsGridText::class]
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

    public static function friendlyName()
    {
    	return 'Layout';
    }
}
