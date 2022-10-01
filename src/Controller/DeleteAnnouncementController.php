<?php

namespace App\Controller;

use App\Resolver\CanAnnouncementBeDeletedResolverInterface;
use App\Resolver\GetAnnouncementsResolverInterface;
use App\Resolver\GetUserResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteAnnouncementController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private $logger;

    private CanAnnouncementBeDeletedResolverInterface $IsRemovable;

    private GetAnnouncementsResolverInterface $getAnnouncements;

    private GetUserResolverInterface $getUser;

    public function __construct(EntityManagerInterface $entityManager, $logger, CanAnnouncementBeDeletedResolverInterface $IsRemovable, GetAnnouncementsResolverInterface $getAnnouncements, GetUserResolverInterface $getUser)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->IsRemovable = $IsRemovable;
        $this->getAnnouncements = $getAnnouncements;
        $this->getUser = $getUser;
    }

    /**
     * @Route("/delete/announcement/{id}", name="app_delete_announcement")
     */
    public function index(int $id): Response
    {
        $announcement = $this->getAnnouncements->getAnnouncementById($id);
        $user = $this->getUser->getUser();
        
        if($this->IsRemovable->isRemovable($id)) {
            $this->entityManager->remove($announcement);
            $this->entityManager->flush();

            $this->logger->info('User: '. $user->getUserIdentifier() .' successfully deleted announcement '. $announcement->getTitle());

            return $this->redirectToRoute('app_main_page');
        }
            $this->logger->warning('User: '. $user->getUserIdentifier() .' tried to remove announcement: '. $announcement->getTitle() .' without permission');

            return $this->redirectToRoute('app_announcement', ['id'=> $id]);
    }
}
