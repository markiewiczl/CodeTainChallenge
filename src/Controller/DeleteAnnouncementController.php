<?php

namespace App\Controller;

use App\Repository\AnnouncementsRepository;
use App\Resolver\CanAnnouncementBeDeletedResolverInterface;
use App\Resolver\GetUserResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DeleteAnnouncementController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private $logger;

    private CanAnnouncementBeDeletedResolverInterface $IsRemovable;

    private AnnouncementsRepository $announcementsRepository;

    private GetUserResolverInterface $getUser;

    public function __construct(
        EntityManagerInterface $entityManager,
        $logger,
        CanAnnouncementBeDeletedResolverInterface $IsRemovable,
        AnnouncementsRepository $announcementsRepository,
        GetUserResolverInterface $getUser
    )
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->IsRemovable = $IsRemovable;
        $this->announcementsRepository = $announcementsRepository;
        $this->getUser = $getUser;
    }

    public function index(int $id): Response
    {
        $announcement = $this->announcementsRepository->findOneBy(['id' => $id]);
        $user = $this->getUser->getUser();

        if ($this->IsRemovable->isRemovable($id)) {
            $this->entityManager->remove($announcement);
            $this->entityManager->flush();

            $this->logger->info('User: '. $user->getUserIdentifier() .' successfully deleted announcement '. $announcement->getTitle());

            return $this->redirectToRoute('app_main_page');
        }
        $this->logger->warning('User: '. $user->getUserIdentifier() .' tried to remove announcement: '. $announcement->getTitle() .' without permission');

        return $this->redirectToRoute('app_announcement', ['id'=> $id]);
    }
}
