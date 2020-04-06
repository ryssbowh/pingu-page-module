<?php

namespace Pingu\Page\Entities\Policies;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Support\Policies\BaseEntityPolicy;
use Pingu\Page\Entities\Page;
use Pingu\User\Entities\User;

class PagePolicy extends BaseEntityPolicy
{
    /**
     * @inheritDoc
     */
    public function index(?User $user)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view pages');
    }

    /**
     * @inheritDoc
     */
    public function view(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        if (!$entity->published and !$user->hasPermissionTo('view unpublished pages')) {
            return false;
        }
        if ($permission = $entity->permission) {
            return $user->hasPermissionTo($permission);
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function edit(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('edit pages');
    }

    /**
     * @inheritDoc
     */
    public function delete(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('delete pages');
    }

    /**
     * @inheritDoc
     */
    public function create(?User $user, ?BundleContract $bundle = null)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('create pages');
    }
}