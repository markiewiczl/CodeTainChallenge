<?php

namespace App\Resolver;

interface CanAnnouncementBeDeletedResolverInterface
{
    public function isRemovable(int $id): Bool;
}