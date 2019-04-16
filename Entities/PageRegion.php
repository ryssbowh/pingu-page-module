<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;
use Modules\Core\Traits\APIableModel;
use Modules\Forms\Traits\Formable;
use Modules\JsGrid\Contracts\JsGridableContract;
use Modules\JsGrid\Traits\JsGridable;
use Modules\Forms\Fields\Text;

class PageRegion extends BaseModel implements
    JsGridableContract
{
	use JsGridable, Formable, APIableModel;

    protected $fillable = [];

    public function layout()
    {
    	return $this->belongsTo("Modules\Page\Entities\PageLayout");
    }

    public function blocks(){
    	return $this->hasMany("Modules\Page\Entities\PageBlock")->withPivot('view_mode_id');
    }

    public static function friendlyName()
    {
    	return 'Region';
    }

    public static function jsGridFields()
    {
    	return [
    		'name' => ['type' => 'text']
    	];
    }

    public static function fieldDefinitions()
    {
        return [
            'name' => [
                'type' => Text::class,
                'label' => 'Name'
            ]
        ];
    }

    public function validationRules()
    {
        return [
            'name' => 'required'
        ];
    }
}
