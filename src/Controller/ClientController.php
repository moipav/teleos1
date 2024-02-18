<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Client;
use App\Form\ClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(\Doctrine\Persistence\ManagerRegistry $doctrine): Response
    {
        $clients = $doctrine->getRepository(Client::class)->findAllJoinedTariffAndAddress();
        return $this->render('client/index.html.twig', [
            'clients'=>$clients
        ]);
    }

    #[Route('/client/create', name:'app_client_create')]
    public function createClient(EntityManagerInterface $entityManager, Request $request): Response
    {
        $client = new Client();
        return $this->extracted($client, $request, $entityManager, 'Добавить нового клинета');
    }

    #[Route('/client/update/{id}', name:'app_client_update')]
    public function updateClient(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $client = $entityManager->getRepository(Client::class)->find($id);
        return $this->extracted($client, $request, $entityManager, 'Изменение данных о клиенте');
    }

    /**
     * @param Client $client
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param $title
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function extracted(Client $client, Request $request, EntityManagerInterface $entityManager, $title): Response|\Symfony\Component\HttpFoundation\RedirectResponse
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();

            $entityManager->persist($client);
            $entityManager->flush();
            return $this->redirectToRoute('app_client');
        }
        return $this->render('client/create.html.twig', [
            'client_form' => $form->createView(),
            'title' => $title
        ]);
    }


}
