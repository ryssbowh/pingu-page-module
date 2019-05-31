<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Contracts\AdminableModel as AdminableModelContract;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\AjaxableModel;
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
	use JsGridableModel, FormableModel, AjaxableModel, AdminableModel;

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

    public static function adminIndexUri()
    {
        return PageLayout::routeSlug().'/{'.PageLayout::routeSlug().'}/'.self::routeSlugs();
    }

    public static function ajaxIndexUri()
    {
        return PageLayout::routeSlug().'/{'.PageLayout::routeSlug().'}/'.self::routeSlugs();
    }

    public static function ajaxPatchUri()
    {
        return static::ajaxIndexUri();
    }

    public static function ajaxDeleteUri()
    {
        return static::routeSlug().'/{'.static::routeSlug().'}';
    }

    public static function ajaxStoreUri()
    {
        return static::ajaxIndexUri();
    }

    public static function ajaxCreateUri()
    {
        return static::ajaxIndexUri().'/create';
    }
}
