<?php

namespace App\Controller;

use App\Resolver\ConvertToCurrentCurrencyResolverInterface;
use App\Resolver\GetAnnouncementsResolverInterface;
use App\Resolver\GetCategoriesResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    private GetAnnouncementsResolverInterface $getAnnouncement;

    private GetCategoriesResolverInterface $getCategories;

    private ConvertToCurrentCurrencyResolverInterface $currencyResolver;

    public function __construct(GetAnnouncementsResolverInterface $getAnnouncement, GetCategoriesResolverInterface $getCategories, ConvertToCurrentCurrencyResolverInterface $currencyResolver)
    {
        $this->getAnnouncement = $getAnnouncement;
        $this->getCategories = $getCategories;
        $this->currencyResolver = $currencyResolver;
    }

    /**
     * @Route("/announcements/{currency}", name="app_main_page", defaults={"currency"="pln"})
     */
    public function index(string $currency): Response
    {
        $announcements = $this->getAnnouncement->getAllAnnouncements();
        $categories = $this->getCategories->getAllCategories();

        if($currency === 'eur') {
            $this->currencyResolver->convert($announcements);
        }

        return $this->render('main_page/index.html.twig', [
            'announcements' => $announcements,
            'categories' => $categories,
            'currency' => $currency,
        ]);
    }

    /**
     * @Route("/{currency}/announcement/{id}", name="app_announcement", defaults={"currency" = "pln"})
     */
    public function announcementById(int $id, string $currency): Response
    {
        $announcement = $this->getAnnouncement->getAnnouncementById($id);
        $categories = $this->getCategories->getAllCategories();

        if($currency === 'eur') {
            $this->currencyResolver->convertOne($announcement);
        }

        return $this->render('main_page/announcement.html.twig', [
           'announcement' => $announcement,
           'categories' => $categories,
            'currency' => $currency,
        ]);
    }

    /**
     * @Route("/{currency}/announcements/{categoryId}", name="app_announcements", defaults={"currency"="pln"})
     */
    public function announcementByCategory(int $categoryId, string $currency): Response
    {
        $announcements = $this->getAnnouncement->getAnnouncementsByCategory($categoryId);
        $categories = $this->getCategories->getAllCategories();

        if($currency === 'eur') {
            $this->currencyResolver->convert($announcements);
        }

        return $this->render('main_page/announcements.html.twig', [
            'announcements' => $announcements,
            'categories' => $categories,
            'currency' => $currency,
        ]);
    }

    /**
     * @Route("/{currency}/announcements/{column}/{order}", name="app_announcements_ordered", defaults={"currency"="pln"})
     */
    public function announcementsOrdered(string $column, string $order, string $currency):Response
    {
        $announcemetns = $this->getAnnouncement->getAnnouncementsByColumn($order, $column);
        $categories = $this->getCategories->getAllCategories();

        if($currency === 'eur') {
            $this->currencyResolver->convert($announcemetns);
        }

        return $this->renderForm('main_page/ordered_announcements.html.twig', [
            'announcements' => $announcemetns,
            'categories' => $categories,
            'currency' => $currency,
        ]);
    }
}
