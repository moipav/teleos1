<?php

namespace App\Controller;

use App\Entity\Tariff;
use App\Form\TariffType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TariffController extends AbstractController
{
    #[Route('/tariff', name: 'app_tariff')]
    public function index(\Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $tariffs = $doctrine->getRepository(Tariff::class)->findAll();

        return $this->render('tariff/index.html.twig', [
            'tariffs' => $tariffs,
        ]);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    #[Route('/tariff/create', name: 'app_tariff_create')]
    public function createTariff(EntityManagerInterface $entityManager, Environment $twig, Request $request): Response
    {
        $tariff = new Tariff();

        $form = $this->createForm(TariffType::class, $tariff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tariff = $form->getData();

            $entityManager->persist($tariff);
            $entityManager->flush();
            $this->redirectToRoute('app_tariff_create');
        }
        return $this->render('tariff/create.html.twig', [
            'tariff_form' => $form->createView()
        ]);

    }

}
