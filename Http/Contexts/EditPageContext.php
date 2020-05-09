<?php

namespace Pingu\Page\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Http\Contexts\EditContext;

class EditPageContext extends EditContext
{
    /**
     * @inheritDoc
     */
    public function getFields(): Collection
    {
        $fields = parent::getFields();
        $fields->get('machineName')->option('disabled', true);
        return $fields;
    }
}