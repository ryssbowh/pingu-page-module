<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\AdminableModel as AdminableModelContract;
use Pingu\Core\Contracts\HasContextualLinks;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\APIableModel;
use Pingu\Core\Traits\AdminableModel;
use Pingu\Forms\Fields\{Text, Model};
use Pingu\Forms\Traits\FormableModel;
use Pingu\Jsgrid\Contracts\JsGridableModel as JsGridableModelContract;
use Pingu\Jsgrid\Fields\{Text as JsGridText, Model as JsGridModel};
use Pingu\Jsgrid\Traits\JsGridableModel;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;

class Page extends BaseModel implements
    JsGridableModelContract, HasContextualLinks, AdminableModelContract
{
	use JsGridableModel, FormableModel, APIableModel, AdminableModel;

    protected $fillable = ['name', 'slug', 'page_layout'];

    protected $visible = ['id', 'name', 'slug', 'page_layout'];

    protected $with = ['page_layout'];

    public static $fieldDefinitions = [
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

    public static $validationRules = [
        'name' => 'required',
        'slug' => 'required|unique:pages,slug,{id}',
        'page_layout' => 'required|exists:page_layouts,id'
    ];

    public static $validationMessages = [
        'name.required' => 'Name is required',
        'slug.required' => 'Url is required',
        'slug.unique' => 'This url already exists',
        'page_layout.required' => 'Layout is required'
    ];

    public static $editFields = ['name', 'slug', 'page_layout'];

    public static $addFields = ['name', 'slug', 'page_layout'];

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

    public function getContextualLinks(): array
    {
        return [
            'edit' => [
                'title' => 'Edit',
                'url' => $this::transformAdminUri('edit', [$this->id], true)
            ],
            'users' => [
                'model' => Block::class,
                'title' => 'Blocks',
                'url' => Block::transformAdminUri('index', [$this->id], true),
                // 'relatedAddUrl' => Block::adminAddUrl().'?fields[role]='.$this->id
            ]
        ];
    }
}
