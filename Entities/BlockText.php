<?php

namespace Pingu\Page\Entities;

use Pingu\Core\Entities\BaseModel;
use Pingu\Forms\Contracts\Models\FormableContract;
use Pingu\Forms\Fields\Model\Text;
use Pingu\Forms\Renderers\Text as TextRenderer;
use Pingu\Forms\Renderers\Textarea;
use Pingu\Forms\Traits\Models\Formable;
use Pingu\Page\Entities\Block;
use Pingu\Page\Traits\Blockable;

class BlockText extends BaseModel implements 
	FormableContract
{
	use Formable, Blockable;

    protected $fillable = ['name', 'text'];

    protected $visible = ['id', 'text', 'name'];

        /**
     * @inheritDoc
     */
    public function formAddFields()
    {
        return ['name', 'text'];
    }

    /**
     * @inheritDoc
     */
    public function formEditFields()
    {
        return ['name', 'text'];
    }

    /**
     * @inheritDoc
     */
    public function fieldDefinitions()
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

    /**
     * @inheritDoc
     */
    public function validationRules()
    {
        return [
            'text' => 'required|string',
            'name' => 'required|string'
        ];
    }

    /**
     * @inheritDoc
     */
    public function validationMessages()
    {
        return [
            'text.required' => 'Text is required',
            'name.required' => 'Name is required'
        ];
    }

    public function block()
    {
        return $this->morphOne(Block::class, 'instance');
    }

}
