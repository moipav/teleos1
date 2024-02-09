<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TariffController extends AbstractController
{
    #[Route('/tariff', name: 'app_tariff')]
    public function index(): Response
    {
        return $this->render('tariff/index.html.twig', [
            'controller_name' => 'TariffController',
        ]);
    }
}
