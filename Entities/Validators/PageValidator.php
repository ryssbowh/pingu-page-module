<?php

namespace Pingu\Page\Entities\Validators;

use Pingu\Field\Support\FieldValidator\BaseFieldsValidator;

class PageValidator extends BaseFieldsValidator
{
    protected function rules(bool $updating): array
    {
        return [
            'name' => 'required',
            'machineName' => 'required|unique:pages,machineName,'.$this->object->id,
            'slug' => 'required|unique:pages,slug,'.$this->object->id,
            'layout' => 'required',
            'published' => 'boolean'
        ];
    }

    protected function messages(): array
    {
        return [

        ];
    }
} 