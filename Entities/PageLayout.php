<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\AdminableModel as AdminableModelContract;
use Pingu\Core\Contracts\HasContextualLinks;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\AjaxableModel;
use Pingu\Core\Traits\AdminableModel;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\Traits\FormableModel;
use Pingu\Jsgrid\Contracts\JsGridableModel as JsGridableModelContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\JsGridableModel;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class PageLayout extends BaseModel implements
    JsGridableModelContract, HasContextualLinks, AdminableModelContract
{
    use JsGridableModel, FormableModel, AjaxableModel, AdminableModel;

    protected $fillable = ['name'];

    protected $visible = ['id', 'name'];

    public static $fieldDefinitions = [
        'name' => [
            'type' => Text::class,
            'label' => 'Name'
        ]
    ];

    public static $validationRules = [
        'name' => 'required|unique:page_layouts,name,{id}'
    ];

    public static $editFields = ['name'];

    public static $addFields = ['name'];

    public static function friendlyName()
    {
        return 'Layout';
    }

    public function pages()
    {
    	return $this->hasMany(Page::class);
    }

    public function regions()
    {
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

    public function getContextualLinks(): array
    {
        return [
            'edit' => [
                'title' => 'Edit',
                'url' => $this::transformAdminUri('edit', [$this->id], true)
            ],
            'regions' => [
                'model' => PageRegion::class,
                'title' => 'Regions',
                'url' => '/admin/'.$this::routeSlug().'/'.$this->id.'/'.PageRegion::routeSlugs()
            ]
        ];
    }
}
