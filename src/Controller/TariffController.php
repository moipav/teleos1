<?php

namespace App\Controller;

use App\Entity\Tariff;
use App\Form\TariffType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function createTariff(EntityManagerInterface $entityManager, Request $request): Response
    {
        $tariff = new Tariff();

        return $this->extracted($tariff, $request, $entityManager);

    }

    #[Route('/tariff/delete/{id}', name: 'app_tariff_delete')]
    public function deleteTariff(EntityManagerInterface $entityManager, int $id): Response
    {
        $tariff = $entityManager->getRepository(Tariff::class)->find($id);
        $entityManager->remove($tariff);
        $entityManager->flush();
        return $this->redirectToRoute('app_tariff');
    }

    #[Route('tariff/update/{id}', name: 'app_tariff_update')]
    public function updateTariff(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $tariff = $entityManager->getRepository(Tariff::class)->find($id);

        return $this->extracted($tariff, $request, $entityManager);

    }

    /**
     * @param Tariff $tariff
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    private function extracted(Tariff $tariff, Request $request, EntityManagerInterface $entityManager): Response|RedirectResponse
    {
        $form = $this->createForm(TariffType::class, $tariff);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tariff = $form->getData();

            $entityManager->persist($tariff);
            $entityManager->flush();
            return $this->redirectToRoute('app_tariff');
        }
        return $this->render('tariff/create.html.twig', [
            'tariff_form' => $form->createView()
        ]);
    }
}
