<?php

namespace Pingu\Page\Entities\Validators;

use Pingu\Field\Support\FieldValidator\BaseFieldsValidator;

class PageValidator extends BaseFieldsValidator
{
    protected function rules(): array
    {
        return [
            'name' => 'required',
            'slug' => 'required|unique:pages,slug,'.$this->object->id,
            'layout' => 'required'
        ];
    }

    protected function messages(): array
    {
        return [

        ];
    }
}