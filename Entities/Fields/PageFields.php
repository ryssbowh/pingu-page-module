<?php

namespace Pingu\Page\Entities\Fields;

use Pingu\Field\BaseFields\Boolean;
use Pingu\Field\BaseFields\Model;
use Pingu\Field\BaseFields\Text;
use Pingu\Field\BaseFields\_List;
use Pingu\Field\Support\FieldRepository\BaseFieldRepository;
use Pingu\Permissions\Entities\Permission;

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
                'machineName',
                [
                    'label' => 'Machine Name',
                    'required' => true,
                    'dashifyFrom' => 'name'
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
            ),
            new Model(
                'permission',
                [
                    'model' => Permission::class,
                    'label' => 'Viewing permission',
                    'items' => \Permissions::all()->sortBy('section'),
                    'textField' => ['section', 'name'],
                    'separator' => ' : ',
                    'noValueLabel' => 'None'
                ]
            ),
            new Boolean('published')
        ];
    }
}