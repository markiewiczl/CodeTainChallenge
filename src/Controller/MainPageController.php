<?php

namespace App\Controller;

use App\Resolver\GetAnnouncementsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    private GetAnnouncementsResolverInterface $getAnnouncement;

    public function __construct(GetAnnouncementsResolverInterface $getAnnouncement)
    {
        $this->getAnnouncement = $getAnnouncement;
    }

    /**
     * @Route("/", name="app_main_page")
     */
    public function index(): Response
    {
        $announcements = $this->getAnnouncement->getAllAnnouncements();

        return $this->render('main_page/index.html.twig', [
            'announcements' => $announcements,
        ]);
    }

    /**
     * @Route("/announcement/{id}", name="app_announcement")
     */
    public function announcementById(int $id)
    {
        $announcement = $this->getAnnouncement->getAnnouncementById($id);

        return $this->render('main_page/announcement.html.twig', [
           'announcement' => $announcement,
        ]);
    }

    /**
     * @Route("/announcements/{categoryId}", name="app_announcements")
     */
    public function announcementByCategory(int $categoryId)
    {
        $announcement = $this->getAnnouncement->getAnnouncementsByCategory($categoryId);

        return $this->render('main_page/announcements.html.twig', [
            'announcement' => $announcement,
        ]);
    }
}
