<?php

namespace Modules\Page\Entities;

use Modules\Core\Entities\BaseModel;
use Modules\Forms\Fields\Text;
use Modules\Forms\Renderers\Textarea;
use Modules\Forms\Renderers\Text as TextRenderer;
use Modules\Forms\Traits\Formable;
use Modules\Page\Contracts\FormableBlockContract;
use Modules\Page\Entities\Block;
use Modules\Page\Traits\Blockable;

class BlockText extends BaseModel implements 
	FormableBlockContract
{
	use Formable, Blockable;

    protected $fillable = ['name', 'text'];

    public static function fieldDefinitions()
    {
    	return [
    		'text' => [
    			'type' => Text::class,
    			'renderer' => Textarea::class,
    			'attributes' => ['required' => true],
    		],
    		'name' => [
    			'type' => Text::class,
    			'renderer' => TextRenderer::class,
    			'attributes' => ['required' => true],
    		]
    	];
    }

    public function validationRules()
    {
    	return [
    		'text' => 'required',
    		'name' => 'required'
    	];
    }

}
