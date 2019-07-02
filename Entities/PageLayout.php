<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\Models\HasAdminRoutesContract;
use Pingu\Core\Contracts\Models\HasContextualLinksContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasAdminRoutes;
use Pingu\Core\Traits\Models\HasAjaxRoutes;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Types\Text;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Jsgrid\Contracts\Models\JsGridableContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\Models\JsGridable;
use Pingu\Page\Entities\Page;
use Pingu\Page\Entities\PageRegion;

class PageLayout extends BaseModel implements
    JsGridableContract, HasContextualLinksContract, HasAdminRoutesContract
{
    use JsGridable, Formable, HasAjaxRoutes, HasAdminRoutes, HasRouteSlug;

    protected $fillable = ['name'];

    protected $visible = ['id', 'name'];

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name'];
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
    {
        return [
            'name' => [
                'field' => TextInput::class,
                'options' => [
                    'type' => Text::class
                ]
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationRules()
    {
        return [
            'name' => 'required|unique:page_layouts,name,{id}'
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function friendlyName()
    {
        return 'Layout';
    }

    /**
     * Pages relation
     * @return Relation
     */
    public function pages()
    {
    	return $this->hasMany(Page::class);
    }

    /**
     * Page reions relation
     * @return Relation
     */
    public function regions()
    {
    	return $this->hasMany(PageRegion::class);
    }

    public function jsGridFields()
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
                'url' => $this::transformAdminUri('edit', [$this], true)
            ],
            'regions' => [
                'model' => PageRegion::class,
                'title' => 'Regions',
                'url' => '/admin/'.$this::routeSlug().'/'.$this->id.'/'.PageRegion::routeSlugs()
            ]
        ];
    }
}
