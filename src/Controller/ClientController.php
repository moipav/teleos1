<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(\Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $clients = $doctrine->getRepository(Client::class)->findAll();

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients'=>$clients
        ]);
    }
}
