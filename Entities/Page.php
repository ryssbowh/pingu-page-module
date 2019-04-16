<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;
use Modules\Core\Traits\APIableModel;
use Modules\Forms\Fields\{Text, Model};
use Modules\Forms\Traits\Formable;
use Modules\JsGrid\Components\{Text as JsGridText, Model as JsGridModel};
use Modules\JsGrid\Contracts\JsGridableContract;
use Modules\JsGrid\Traits\JsGridable;
use Modules\Page\Entities\PageLayout;

class Page extends BaseModel implements
    JsGridableContract
{
	use JsGridable, Formable, APIableModel;

    protected $fillable = ['name', 'slug', 'page_layout'];

    protected $visible = ['id', 'name', 'slug', 'page_layout'];

    protected $with = ['page_layout'];

    public function page_layout()
    {
    	return $this->belongsTo("Modules\Page\Entities\PageLayout");
    }

    public static function jsGridFields()
    {
    	return [
            'name' => [
                'type' => JsGridText::class
            ], 
            'slug' => [
                'type' => JsGridText::class
            ], 
            'page_layout' => [
                'type' => JsGridModel::class
            ]
        ];
    }

    public static function fieldDefinitions()
    {
        return [
            'name' => [
                'type' => Text::class,
                'label' => 'Name'
            ],
            'slug' => [
                'type' => Text::class,
                'label' => 'Url'
            ],
            'page_layout' => [
                'type' => Model::class,
                'label' => 'Layout',
                'allowNoValue' => false,
                'model' => PageLayout::class,
                'textField' => ['name']
            ]
        ];
    }

    public function validationRules()
    {
        return [
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,'.$this->id,
            'page_layout' => 'required|exists:page_layouts,id'
        ];
    }

    public function validationMessages()
    {
        return [
            'name.required' => 'Name is required',
            'slug.required' => 'Url is required',
            'slug.unique' => 'This url already exists',
            'page_layout.required' => 'Layout is required'
        ];
    }
}
