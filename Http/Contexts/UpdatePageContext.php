<?php

namespace Pingu\Page\Http\Contexts;

use Pingu\Core\Http\Contexts\UpdateContext;
use Pingu\Field\Contracts\HasFieldsContract;

class UpdatePageContext extends UpdateContext
{
    /**
     * @inheritDoc
     */
    public function getValidationRules(HasFieldsContract $model): array
    {
        $rules = $model->fieldRepository()->validationRules()->except('machineName');
        $rules->put('slug', 'required|unique:pages,slug,'.$model->id);
        return $rules->toArray();
    }
}