<?php

namespace App\Resolver;

use App\Entity\Announcements;
use App\Repository\AnnouncementsRepository;

class GetAnnouncementsResolver implements GetAnnouncementsResolverInterface
{
    private AnnouncementsRepository $announcementsRepository;

    public function __construct(AnnouncementsRepository $announcementsRepository)
    {
        $this->announcementsRepository = $announcementsRepository;
    }

    public function getAllAnnouncements()
    {
        $announcements = $this->announcementsRepository->findAll();

        return $announcements;
    }

    public function getAnnouncementById(int $id): Announcements
    {
        $announcement = $this->announcementsRepository->findOneBy(['id' => $id]);

        return $announcement;
    }

    public function getAnnouncementsByCategory(int $categoryId)
    {
        $announcements = $this->announcementsRepository->findBy(['categoryId' => $categoryId]);

        return$announcements;
    }
}