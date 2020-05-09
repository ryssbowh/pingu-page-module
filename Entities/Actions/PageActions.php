<?php

namespace Pingu\Page\Entities\Actions;

use Pingu\Core\Support\Actions\BaseAction;
use Pingu\Entity\Support\Actions\BaseEntityActions;

class PageActions extends BaseEntityActions
{
    public function actions(): array
    {
        return [
            'content' => new BaseAction(
                'Content',
                function ($entity) {
                    return $entity->uris()->make('content', $entity, adminPrefix());
                },
                function ($entity) {
                    return \Gate::check('edit', $entity);
                },
                'admin'
            )
        ];
    }
}