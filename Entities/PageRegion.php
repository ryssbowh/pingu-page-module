<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\AdminableModel as AdminableModelContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\APIableModel;
use Pingu\Core\Traits\AdminableModel;
use Pingu\Forms\Fields\Model;
use Pingu\Forms\Fields\Number;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\Renderers\Hidden;
use Pingu\Forms\Traits\FormableModel;
use Pingu\Jsgrid\Contracts\JsGridableModel as JsGridableModelContract;
use Pingu\Jsgrid\Fields\Text as JsGridText;
use Pingu\Jsgrid\Traits\JsGridableModel;
use Pingu\Page\Entities\Block;
use Pingu\Page\Entities\PageLayout;

class PageRegion extends BaseModel implements
    JsGridableModelContract, AdminableModelContract
{
	use JsGridableModel, FormableModel, APIableModel, AdminableModel;

    protected $fillable = ['name', 'width', 'height','page_layout'];

    protected $visible = ['id','name','width','height'];

    protected $attributes = [
        'width' => 50,
        'height' => 200
    ];

    public static $fieldDefinitions = [
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

    public static $validationRules = [
        'name' => 'required',
        'page_layout' => 'required|exists:page_layouts,id',
        'width' => 'numeric',
        'height' => 'numeric'
    ];

    public static $addFields = ['name', 'page_layout'];

    public static $editFields = ['name'];

    public static function friendlyName()
    {
        return 'Region';
    }

    public function page_layout()
    {
    	return $this->belongsTo(PageLayout::class);
    }

    public function blocks()
    {
    	return $this->belongsToMany(Block::class)->withTimestamps()->withPivot('weight');
    }

    public function getBlocks()
    {
        return $this->blocks()->orderBy('weight','asc')->get();
    }

    public static function jsGridFields()
    {
    	return [
    		'name' => [
                'type' => JsGridText::class
            ]
    	];
    }

    public static function adminIndexUri()
    {
        return PageLayout::routeSlug().'/{'.PageLayout::routeSlug().'}/'.self::routeSlugs();
    }

    public static function apiIndexUri()
    {
        return PageLayout::routeSlug().'/{'.PageLayout::routeSlug().'}/'.self::routeSlugs();
    }

    public static function apiPatchUri()
    {
        return static::apiIndexUri();
    }

    public static function apiDeleteUri()
    {
        return static::routeSlug().'/{'.static::routeSlug().'}';
    }

    public static function apiStoreUri()
    {
        return static::apiIndexUri();
    }

    public static function apiCreateUri()
    {
        return static::apiIndexUri().'/create';
    }
}
