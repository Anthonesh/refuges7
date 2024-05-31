<?php

namespace App\Controller;

use App\Entity\Benevolat;
use App\Form\BenevolatType;
use App\Repository\BenevolatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/benevolat')]
class BenevolatController extends AbstractController
{
    #[Route('/', name: 'app_benevolat_index', methods: ['GET'])]
    public function index(BenevolatRepository $benevolatRepository): Response
    {
        return $this->render('benevolat/index.html.twig', [
            'benevolats' => $benevolatRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_benevolat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $benevolat = new Benevolat();
        $form = $this->createForm(BenevolatType::class, $benevolat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($benevolat);
            $entityManager->flush();

            return $this->redirectToRoute('app_benevolat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('benevolat/new.html.twig', [
            'benevolat' => $benevolat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_benevolat_show', methods: ['GET'])]
    public function show(Benevolat $benevolat): Response
    {
        return $this->render('benevolat/show.html.twig', [
            'benevolat' => $benevolat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_benevolat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Benevolat $benevolat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BenevolatType::class, $benevolat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_benevolat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('benevolat/edit.html.twig', [
            'benevolat' => $benevolat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_benevolat_delete', methods: ['POST'])]
    public function delete(Request $request, Benevolat $benevolat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$benevolat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($benevolat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_benevolat_index', [], Response::HTTP_SEE_OTHER);
    }
}
