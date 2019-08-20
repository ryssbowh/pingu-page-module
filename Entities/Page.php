<?php

namespace Pingu\Page\Entities;

use Pingu\Block\Entities\Block;
use Pingu\Core\Contracts\Models\HasContextualLinksContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasBasicCrudUris;
use Pingu\Forms\Support\Fields\Checkboxes;
use Pingu\Forms\Support\Fields\ModelSelect;
use Pingu\Forms\Support\Fields\Select;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Types\Model;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Jsgrid\Contracts\Models\JsGridableContract;
use Pingu\Jsgrid\Fields\{Text as JsGridText, ModelSelect as JsGridModelSelect};
use Pingu\Jsgrid\Traits\Models\JsGridable;
use Pingu\Page\Entities\PageLayout;
use Pingu\Page\Entities\PageRegion;
use Pingu\Page\Exceptions\PageNotfoundException;

class Page extends BaseModel implements
    JsGridableContract, HasContextualLinksContract
{
	use JsGridable, Formable, HasBasicCrudUris;

    protected $fillable = ['name', 'slug', 'layout'];

    protected $visible = ['id', 'name', 'slug', 'layout'];

    protected $with = [];

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'slug', 'layout'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'slug', 'layout'];
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
            'layout' => [
                'field' => Select::class,
                'options' => [
                    'items' => \Theme::front()->getSetting('layouts')
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
            'layout' => 'required'
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
            'layout.required' => 'Layout is required'
        ];
    }

    public static function findBySlug(string $slug)
    {
        $page = static::where(['slug' => $slug])->first();
        if(!$page){
            throw new PageNotfoundException($slug);
        }
        return $page;
    }

    /**
     * Page layout relation
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
            ], 
            'slug' => [
                'type' => JsGridText::class
            ],
            'layout' => [
                'type' => JsGridText::class
            ]
        ];
    }

    public function getContextualLinks(): array
    {
        return [
            'edit' => [
                'title' => 'Edit',
                'url' => $this::makeUri('edit', $this, adminPrefix())
            ],
            'regions' => [
                'title' => 'Layout',
                'url' => PageRegion::makeUri('index', $this, adminPrefix()),
            ],
            'blocks' => [
                'title' => 'Blocks',
                'url' => static::makeUri('blocks', $this, adminPrefix()),
            ]
        ];
    }

    public static function blocksUri()
    {
        return Page::routeSlug().'/{'.Page::routeSlug().'}/'.Block::routeSlugs();
    }

    public static function patchBlocksUri()
    {
        return Page::routeSlug().'/'.Block::routeSlugs();
    }
}
