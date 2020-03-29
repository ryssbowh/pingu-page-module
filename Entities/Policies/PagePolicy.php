<?php

namespace Pingu\Page\Entities\Policies;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Support\Policies\BaseEntityPolicy;
use Pingu\Page\Entities\Page;
use Pingu\User\Entities\User;

class PagePolicy extends BaseEntityPolicy
{
    public function index(?User $user)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view pages');
    }

    public function view(?User $user, Entity $entity)
    {
        if ($permission = $entity->permission) {
            $user = $this->userOrGuest($user);
            return $user->hasPermissionTo($permission);
        }
        return true;
    }

    public function edit(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('edit pages');
    }

    public function delete(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('delete pages');
    }

    public function create(?User $user, ?BundleContract $bundle = null)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('create pages');
    }
}