<?php

namespace Pingu\Page\Entities\Policies;

use Pingu\Page\Entities\Page;
use Pingu\Core\Support\Policy;
use Pingu\Entity\Entities\Entity;
use Pingu\User\Entities\User;

class PagePolicy extends Policy
{
    protected function userOrGuest(?User $user)
    {
        return $user ? $user : \Permissions::guestRole();
    }

    public function index(?User $user)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view '. Page::friendlyNames());
    }

    public function view(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('view '.$entity::friendlyNames());
    }

    public function edit(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('edit '.$entity::friendlyNames());
    }

    public function delete(?User $user, Entity $entity)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('delete '.$entity::friendlyNames());
    }

    public function create(?User $user)
    {
        $user = $this->userOrGuest($user);
        return $user->hasPermissionTo('create '. Page::friendlyNames());
    }
}