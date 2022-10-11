<?php

namespace App\Resolver;

interface CanAnnouncementBeDeletedResolverInterface
{
    public const DAY_REMOVABLE = 'mon';
    public const START_TIME_REMOVABLE = '12:00';
    public const END_TIME_REMOVABLE = '12:04';

    public function isRemovable(int $id): Bool;
}
