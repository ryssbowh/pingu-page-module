<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\APIableModel;
use Pingu\Forms\Fields\{Text, Model};
use Pingu\Forms\Traits\Formable;
use Pingu\Jsgrid\Contracts\JsGridableContract;
use Pingu\Jsgrid\Fields\{Text as JsGridText, Model as JsGridModel};
use Pingu\Jsgrid\Traits\JsGridable;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;

class Page extends BaseModel implements
    JsGridableContract
{
	use JsGridable, Formable, APIableModel;

    protected $fillable = ['name', 'slug', 'page_layout'];

    protected $visible = ['id', 'name', 'slug', 'page_layout'];

    protected $with = ['page_layout'];

    public function page_layout()
    {
    	return $this->belongsTo(PageLayout::class);
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

    public function getContextualLinks()
    {
        return [
            'edit' => [
                'title' => 'Edit',
                'url' => $this::adminEditUrl().'/'.$this->id
            ],
            'users' => [
                'model' => Block::class,
                'title' => 'Blocks',
                'url' => $this::adminEditUrl().'/'.$this->id.'/'.Block::urlSegments(),
                'relatedAddUrl' => Block::adminAddUrl().'?fields[role]='.$this->id
            ]
        ];
    }
}
