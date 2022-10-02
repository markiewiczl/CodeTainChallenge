<?php

namespace App\Resolver;

use App\Entity\Announcements;

interface GetAnnouncementsResolverInterface
{
    public function getAllAnnouncements();

    public function getAnnouncementById(int $id): Announcements;

    public function getAnnouncementsByCategory(int $categoryId);

    public function getAnnouncementsByColumn(string $order, string $column);
}