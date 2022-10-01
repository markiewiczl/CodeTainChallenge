<?php

namespace App\Resolver;

use phpDocumentor\Reflection\Types\Boolean;
use Psr\Log\LoggerInterface;

class CanAnnouncementBeDeletedResolver implements CanAnnouncementBeDeletedResolverInterface
{
    private GetUserResolverInterface $getUser;

    private GetAnnouncementsResolverInterface $getAnnouncement;

    public function __construct(GetUserResolverInterface $getUser, GetAnnouncementsResolverInterface $getAnnouncement)
    {
        $this->getUser = $getUser;
        $this->getAnnouncement = $getAnnouncement;
    }

    public function isRemovable(int $id): Bool
    {
        $announcement = $this->getAnnouncement->getAnnouncementById($id);
        $user = $this->getUser->getUser();
        $day = date('D');
        $date = new \DateTime('now');
        $hour = date_format($date, 'H:i');
        if (($user === $announcement->getUser()) || ($day === 'Sat' && $hour >= '12:00' && $hour <= '12:04')) {
            return true;
        }
        return false;
    }
}