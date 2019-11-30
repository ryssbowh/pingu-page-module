<?php

namespace Pingu\Page\Entities\Fields;

use Pingu\Field\BaseFields\Text;
use Pingu\Field\BaseFields\_List;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;

class PageFields extends BaseFieldRepository
{
    protected function fields(): array
    {
        return [
            new Text(
                'name',
                [
                    'required' => true
                ]
            ),
            new Text(
                'slug',
                [
                    'label' => 'Url',
                    'required' => true
                ]
            ),
            new _List(
                'layout',
                [
                    'items' => \Theme::front()->getLayoutsArray()
                ]
            )
        ];
    }
}