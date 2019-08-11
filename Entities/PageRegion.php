<?php

namespace Pingu\Page\Entities;

use Pingu\Block\Entities\Block;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasBasicCrudUris;
use Pingu\Forms\Support\Fields\Hidden;
use Pingu\Forms\Support\Fields\NumberInput;
use Pingu\Forms\Support\Fields\TextInput;
use Pingu\Forms\Support\Types\Model;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Jsgrid\Contracts\Models\JsGridableContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\Models\JsGridable;
use Pingu\Page\Entities\Page;

class PageRegion extends BaseModel implements
    JsGridableContract
{
    use JsGridable, Formable, HasBasicCrudUris;

    protected $fillable = ['name', 'width', 'height','page'];

    protected $visible = ['id','name','width','height'];

    protected $attributes = [
        'width' => 50,
        'height' => 200
    ];

    /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'page'];
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
                'field' => TextInput::class
            ],
            'width' => [
                'field' => NumberInput::class
            ],
            'height' => [
                'field' => NumberInput::class
            ],
            'page' => [
                'field' => Hidden::class,
                'options' => [
                    'model' => Page::class,
                    'textField' => ['name'],
                    'type' => Model::class
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
            'name' => 'required|string',
            'page' => 'required|exists:pages,id',
            'width' => 'numeric',
            'height' => 'numeric'
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [
            'default.valid_url' => 'Default is not a valid url'
        ];
    }

    /**
     * @inheritDoc
     */
    public static function friendlyName()
    {
        return 'Region';
    }

    /**
     * Page layout relation
     * @return Relation
     */
    public function page()
    {
    	return $this->belongsTo(Page::class);
    }

    /**
     * blocks relation
     * @return Collection
     */
    public function blocks()
    {
    	return $this->belongsToMany(Block::class)->withTimestamps()->withPivot('weight')->orderBy('weight','asc');
    }

    public function jsGridFields()
    {
    	return [
    		'name' => [
                'type' => JsGridText::class
            ]
    	];
    }

    /**
     * @inheritDoc
     */
    public static function indexUri()
    {
        return Page::routeSlug().'/{'.Page::routeSlug().'}/'.self::routeSlugs();
    }

    /**
     * @inheritDoc
     */
    public static function patchUri()
    {
        return static::indexUri();
    }

    /**
     * @inheritDoc
     */
    public static function storeUri()
    {
        return static::indexUri();
    }

    /**
     * @inheritDoc
     */
    public static function createUri()
    {
        return static::indexUri().'/create';
    }
}
