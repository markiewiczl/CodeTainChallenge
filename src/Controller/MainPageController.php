<?php

namespace App\Controller;

use App\Repository\AnnouncementsRepository;
use App\Repository\CategoriesRepository;
use App\Resolver\ConvertToCurrentCurrencyResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainPageController extends AbstractController
{
    private AnnouncementsRepository $announcementsRepository;

    private CategoriesRepository $categoriesRepository;

    private ConvertToCurrentCurrencyResolverInterface $currencyResolver;

    public function __construct(
        AnnouncementsRepository $announcementsRepository,
        CategoriesRepository $categoriesRepository,
        ConvertToCurrentCurrencyResolverInterface $currencyResolver
    )
    {
        $this->announcementsRepository = $announcementsRepository;
        $this->categoriesRepository = $categoriesRepository;
        $this->currencyResolver = $currencyResolver;
    }

    public function index(string $currency): Response
    {
        $announcements = $this->announcementsRepository->findAll();
        $categories = $this->categoriesRepository->findAll();

        if ($currency === 'eur') {
            $this->currencyResolver->convert($announcements);
        }

        return $this->render('main_page/index.html.twig', [
            'announcements' => $announcements,
            'categories' => $categories,
            'currency' => $currency,
        ]);
    }

    public function announcementById(int $id, string $currency): Response
    {
        $announcement = $this->announcementsRepository->findOneBy(['id' => $id]);
        $categories = $this->categoriesRepository->findAll();

        if ($currency === 'eur') {
            $this->currencyResolver->convertOne($announcement);
        }

        return $this->render('main_page/announcement.html.twig', [
           'announcement' => $announcement,
           'categories' => $categories,
            'currency' => $currency,
        ]);
    }

    public function announcementByCategory(int $categoryId, string $currency): Response
    {
        $announcements = $this->announcementsRepository->findBy(['category' => $categoryId]);
        $categories = $this->categoriesRepository->findAll();

        if ($currency === 'eur') {
            $this->currencyResolver->convert($announcements);
        }

        return $this->render('main_page/announcements.html.twig', [
            'announcements' => $announcements,
            'categories' => $categories,
            'currency' => $currency,
        ]);
    }

    public function announcementsOrdered(string $column, string $order, string $currency): Response
    {
        $announcements = $this->announcementsRepository->orderByColumn($order, $column);
        $categories = $this-> categoriesRepository->findAll();
        ;

        if ($currency === 'eur') {
            $this->currencyResolver->convert($announcements);
        }

        return $this->renderForm('main_page/ordered_announcements.html.twig', [
            'announcements' => $announcements,
            'categories' => $categories,
            'currency' => $currency,
        ]);
    }
}
