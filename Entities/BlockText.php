<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Forms\Fields\Text;
use Pingu\Forms\Renderers\Text as TextRenderer;
use Pingu\Forms\Renderers\Textarea;
use Pingu\Forms\Traits\FormableModel;
use Pingu\Page\Contracts\FormableBlockContract;
use Pingu\Page\Entities\Block;
use Pingu\Page\Traits\Blockable;

class BlockText extends BaseModel implements 
	FormableBlockContract
{
	use FormableModel, Blockable;

    protected $fillable = ['name', 'text'];

    protected $visible = ['id', 'block_id', 'name', 'created_at'];

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
