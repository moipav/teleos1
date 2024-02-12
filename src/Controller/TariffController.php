<?php

namespace App\Controller;

use App\Entity\Tariff;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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


}
