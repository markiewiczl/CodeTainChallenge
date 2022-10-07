<?php

namespace App\Controller;

use App\Resolver\GetAnnouncementsResolverInterface;
use App\Resolver\GetCategoriesResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    private GetAnnouncementsResolverInterface $getAnnouncement;

    private GetCategoriesResolverInterface $getCategories;

    public function __construct(GetAnnouncementsResolverInterface $getAnnouncement, GetCategoriesResolverInterface $getCategories)
    {
        $this->getAnnouncement = $getAnnouncement;
        $this->getCategories = $getCategories;
    }


    /**
     * @Route("/", name="app_main_page")
     */
    public function index(): Response
    {
        $announcements = $this->getAnnouncement->getAllAnnouncements();
        $categories = $this->getCategories->getAllCategories();

        return $this->render('main_page/index.html.twig', [
            'announcements' => $announcements,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/announcement/{id}", name="app_announcement")
     */
    public function announcementById(int $id): Response
    {
        $announcement = $this->getAnnouncement->getAnnouncementById($id);
        $categories = $this->getCategories->getAllCategories();

        return $this->render('main_page/announcement.html.twig', [
           'announcement' => $announcement,
           'categories' => $categories,
        ]);
    }

    /**
     * @Route("/announcements/{categoryId}", name="app_announcements")
     */
    public function announcementByCategory(int $categoryId): Response
    {
        $announcement = $this->getAnnouncement->getAnnouncementsByCategory($categoryId);
        $categories = $this->getCategories->getAllCategories();

        return $this->render('main_page/announcements.html.twig', [
            'announcements' => $announcement,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/announcements/{column}/{order}", name="app_announcements_ordered")
     */
    public function announcementsOrdered(string $column, string $order):Response
    {
        $announcemetns = $this->getAnnouncement->getAnnouncementsByColumn($order, $column);
        $categories = $this->getCategories->getAllCategories();

        return $this->renderForm('main_page/ordered_announcements.html.twig', [
            'announcements' => $announcemetns,
            'categories' => $categories,
        ]);
    }
}
