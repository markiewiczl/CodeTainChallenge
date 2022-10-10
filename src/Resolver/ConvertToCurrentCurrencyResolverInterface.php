<?php

namespace App\Resolver;

use App\Entity\Announcements;

interface ConvertToCurrentCurrencyResolverInterface
{
    public function convert(array $announcements): void;

    public function convertOne(Announcements $announcements): void;
}