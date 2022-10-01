<?php

namespace App\Resolver;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class GetUserResolver implements GetUserResolverInterface
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getUser(): UserInterface
    {
        $user = $this->security->getUser();

        if ($user === null) {
            return new \Exception('Can not found user');
        }

        return $user;
    }
}