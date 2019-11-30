<?php

namespace Pingu\Page\Entities\Actions;

use Pingu\Entity\Support\BaseEntityActions;

class PageActions extends BaseEntityActions
{
    public function actions(): array
    {
        return [
            'edit' => [
                'label' => 'Edit',
                'url' => function ($entity) {
                    return $entity->uris()->make('edit', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('edit', $entity);
                }
            ],
            'delete' => [
                'label' => 'Delete',
                'url' => function ($entity) {
                    return $entity->uris()->make('confirmDelete', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('delete', $entity);
                }
            ],
            'content' => [
                'label' => 'Content',
                'url' => function ($entity) {
                    return $entity->uris()->make('content', $entity, adminPrefix());
                },
                'access' => function ($entity) {
                    return \Gate::check('editContent', $entity);
                }
            ]
        ];
    }
}