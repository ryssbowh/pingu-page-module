<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\Models\HasAdminRoutesContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasAdminRoutes;
use Pingu\Core\Traits\Models\HasAjaxRoutes;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Forms\Fields\Model;
use Pingu\Forms\Fields\Number;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\Renderers\Hidden;
use Pingu\Forms\Traits\Formable;
use Pingu\Jsgrid\Contracts\Models\JsGridableContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\Models\JsGridable;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\PageLayout;

class PageRegion extends BaseModel implements
    JsGridableContract, HasAdminRoutesContract
{
    use JsGridable, Formable, HasAjaxRoutes, HasAdminRoutes, HasRouteSlug;

    protected $fillable = ['name', 'width', 'height','page_layout'];

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
        return ['name', 'page_layout'];
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
                'type' => Text::class,
                'label' => 'Name'
            ],
            'width' => [
                'type' => Number::class
            ],
            'height' => [
                'type' => Number::class
            ],
            'page_layout' => [
                'type' => Model::class,
                'model' => PageLayout::class,
                'textField' => ['name'],
                'renderer' => Hidden::class
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
            'page_layout' => 'required|exists:page_layouts,id',
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
    public function page_layout()
    {
    	return $this->belongsTo(PageLayout::class);
    }

    /**
     * blocks relation
     * @return Collection
     */
    public function blocks()
    {
    	return $this->belongsToMany(Block::class)->withTimestamps()->withPivot('weight')->orderBy('weight','asc');
    }

    public static function jsGridFields()
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
    public static function adminIndexUri()
    {
        return PageLayout::routeSlug().'/{'.PageLayout::routeSlug().'}/'.self::routeSlugs();
    }

    /**
     * @inheritDoc
     */
    public static function ajaxIndexUri()
    {
        return PageLayout::routeSlug().'/{'.PageLayout::routeSlug().'}/'.self::routeSlugs();
    }

    /**
     * @inheritDoc
     */
    public static function ajaxPatchUri()
    {
        return static::ajaxIndexUri();
    }

    /**
     * @inheritDoc
     */
    public static function ajaxStoreUri()
    {
        return static::ajaxIndexUri();
    }

    /**
     * @inheritDoc
     */
    public static function ajaxCreateUri()
    {
        return static::ajaxIndexUri().'/create';
    }
}
