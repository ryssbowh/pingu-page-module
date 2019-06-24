<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\Models\HasAdminRoutesContract;
use Pingu\Core\Contracts\Models\HasContextualLinksContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasAdminRoutes;
use Pingu\Core\Traits\Models\HasAjaxRoutes;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Forms\Support\Fields\Checkboxes;
use Pingu\Forms\Support\Fields\ModelSelect;
use Pingu\Forms\Support\Fields\Select;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Types\Model;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Jsgrid\Contracts\Models\JsGridableContract;
use Pingu\Jsgrid\Fields\{Text as JsGridText, ModelSelect as JsGridModelSelect};
use Pingu\Jsgrid\Traits\Models\JsGridable;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;

class Page extends BaseModel implements
    JsGridableContract, HasContextualLinksContract, HasAdminRoutesContract
{
	use JsGridable, Formable, HasAjaxRoutes, HasAdminRoutes, HasRouteSlug;

    protected $fillable = ['name', 'slug', 'page_layout'];

    protected $visible = ['id', 'name', 'slug', 'page_layout'];

    protected $with = ['page_layout'];

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'slug', 'page_layout'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'slug', 'page_layout'];
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
    {
        return [
            'name' => [
                'field' => TextInput::class,
                'attributes' => [
                    'required' => true
                ]
            ],
            'slug' => [
                'field' => TextInput::class,
                'options' => [
                    'label' => 'Url'
                ],
                'attributes' => [
                    'required' => true
                ]
            ],
            'page_layout' => [
                'field' => ModelSelect::class,
                'options' => [
                    'label' => 'Layout',
                    'allowNoValue' => false,
                    'model' => PageLayout::class,
                    'textField' => ['name'],
                    'type' => Model::class,
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
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,'.$this->id,
            'page_layout' => 'required|exists:page_layouts,id'
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [
            'name.required' => 'Name is required',
            'slug.required' => 'Url is required',
            'slug.unique' => 'This url already exists',
            'page_layout.required' => 'Layout is required'
        ];
    }

    /**
     * Page layout relation
     * @return Relation
     */
    public function page_layout()
    {
        return $this->belongsTo(PageLayout::class);
    }

    public function jsGridFields()
    {
        return [
            'name' => [
                'type' => JsGridText::class
            ], 
            'slug' => [
                'type' => JsGridText::class
            ], 
            'page_layout' => [
                'type' => JsGridModelSelect::class
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
            'users' => [
                'model' => Block::class,
                'title' => 'Blocks',
                'url' => Block::transformAdminUri('index', [$this], true),
                // 'relatedAddUrl' => Block::adminAddUrl().'?fields[role]='.$this->id
            ]
        ];
    }
}
