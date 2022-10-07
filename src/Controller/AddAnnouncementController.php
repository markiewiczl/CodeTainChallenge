<?php

namespace App\Controller;

use App\Entity\Announcements;
use App\Form\AddAnnouncementType;
use App\Resolver\FileUploaderResolverInterface;
use App\Resolver\GetUserResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddAnnouncementController extends AbstractController
{
    private GetUserResolverInterface $getUser;

    private EntityManagerInterface $entityManager;

    private FileUploaderResolverInterface $fileUploader;

    public function __construct(GetUserResolverInterface $getUser, EntityManagerInterface $entityManager, FileUploaderResolverInterface $fileUploader)
    {
        $this->getUser = $getUser;
        $this->entityManager = $entityManager;
        $this->fileUploader = $fileUploader;
    }

    /**
     * Require ROLE_USER for all the actions of this controller
     *
     * @IsGranted("ROLE_USER")
     * @Route("/add/announcement", name="app_add_announcement")
     */
    public function index(Request $request): Response
    {
        $announcement = new Announcements();
        $user = $this->getUser->getUser();
        $announcement->setUser($user);

        $form = $this->createForm(AddAnnouncementType::class, $announcement);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $imageName = $this->fileUploader->upload($image);
                $announcement->setImage($imageName);
            }

            /** @var Announcements $announcement */
            $announcement = $form->getData();
            $announcement->setPriceNet($form->get('priceNet')->getData() * 100);
            $announcement->setPriceGross($announcement->getPriceNet()*1.23);
            $announcement->setCreatedAt(new \DateTime('now'));

            $this->entityManager->persist($announcement);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_main_page');
        }

        return $this->renderForm('add_announcement/index.html.twig', [
            'form' => $form,
        ]);
    }
}
