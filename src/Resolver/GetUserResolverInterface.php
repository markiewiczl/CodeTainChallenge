<?php

namespace App\Resolver;

use Symfony\Component\Security\Core\User\UserInterface;

interface GetUserResolverInterface
{
    public function getUser(): UserInterface;
}