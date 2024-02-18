<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{


    #[Route('/address', name: 'app_address')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $addresses = $doctrine->getRepository(Address::class)->findAll();
        return $this->render('address/index.html.twig', [
            'addresses' => $addresses,
        ]);
    }

    #[Route('/address/create', name: 'app_address_create')]
    public function createAddress(EntityManagerInterface $entityManager, Request $request): Response
    {
        $address =  new Address();

        return $this->extracted('Добавление адреса',$address, $request, $entityManager);
    }

    #[Route('/address/update/{id}', name: 'app_address_update')]
    public function updateAddress(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $address = $entityManager->getRepository(Address::class)->find($id);

        return $this->extracted('Изменение адреса',$address, $request, $entityManager);
    }

    /**
     * @param Address $address
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response|RedirectResponse
     */
    private function extracted($title, Address $address, Request $request, EntityManagerInterface $entityManager): Response|RedirectResponse
    {
        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();

            $entityManager->persist($address);
            $entityManager->flush();
            return $this->redirectToRoute('app_address');
        }
        return $this->render('address/create.html.twig', [
            'title' => $title,
            'address_form' => $form->createView()
        ]);
    }


}
