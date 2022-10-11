<?php

namespace App\Resolver;

use App\Repository\AnnouncementsRepository;

class CanAnnouncementBeDeletedResolver implements CanAnnouncementBeDeletedResolverInterface
{
    private GetUserResolverInterface $getUser;

    private AnnouncementsRepository $announcementsRepository;

    public function __construct(GetUserResolverInterface $getUser, AnnouncementsRepository $announcementsRepository)
    {
        $this->getUser = $getUser;
        $this->announcementsRepository = $announcementsRepository;
    }

    public function isRemovable(int $id): Bool
    {
        $announcement = $this->announcementsRepository->findOneBy(['id' => $id]);
        $user = $this->getUser->getUser();
        $day = date('D');
        $date = new \DateTime('now');
        $hour = date_format($date, 'H:i');
        if (($user === $announcement->getUser())
            || (
                $day === CanAnnouncementBeDeletedResolverInterface::DAY_REMOVABLE &&
                $hour >= CanAnnouncementBeDeletedResolverInterface::START_TIME_REMOVABLE &&
                $hour <= CanAnnouncementBeDeletedResolverInterface::END_TIME_REMOVABLE
            )) {
            return true;
        }
        return false;
    }
}
