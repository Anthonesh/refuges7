<?php

namespace App\Controller;

use App\Entity\Benevolat;
use App\Entity\Formulaires;
use App\Form\FormulairesBenevolatType;
use App\Repository\FormulairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/formulaires/benevole')]
class FormulairesBenevoleController extends AbstractController
{
    #[Route('/', name: 'app_formulaires_benevole_index', methods: ['GET'])]
    public function index(FormulairesRepository $formulairesRepository): Response
    {
        return $this->render('formulaires_benevole/index.html.twig', [
            'formulaires' => $formulairesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_formulaires_benevole_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
    // Récupérer les paramètres depuis l'URL
    $date = $request->query->get('date');
    $heureDebut = $request->query->get('heure_debut');
    $heureFin = $request->query->get('heure_fin');
    $nombreParticipants = $request->query->get('nombre_participants');

    // Créer une nouvelle instance de Benevolat
    $benevolat = new Benevolat();
    $benevolat
        ->setHeureDebutBenevolat(new \DateTime($date . ' ' . $heureDebut))
        ->setHeureFinBenevolat(new \DateTime($date . ' ' . $heureFin))
        ->setNombreTotalBenevolat($nombreParticipants);

    // Créer un nouveau formulaire pour les données du bénévole
    $formulaire = new Formulaires();
    $form = $this->createForm(FormulairesBenevolatType::class, $formulaire);

    // Gérer la soumission du formulaire
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        // Associer le Benevolat au formulaire
        $formulaire->setBenevolat($benevolat);

        // Persister les entités en base de données
        $entityManager->persist($benevolat);
        $entityManager->persist($formulaire);
        $entityManager->flush();

        // Rediriger vers une page de confirmation ou autre
        return $this->redirectToRoute('app_benevole');
    }

    // Afficher le formulaire
    return $this->render('formulaires_benevole/new.html.twig', [
        'form' => $form->createView(),
    ]);
    }
    #[Route('/{id}', name: 'app_formulaires_benevole_show', methods: ['GET'])]
    public function show(Formulaires $formulaire): Response
    {
        return $this->render('formulaires_benevole/show.html.twig', [
            'formulaire' => $formulaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formulaires_benevole_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formulaires $formulaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormulairesBenevolatType::class, $formulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaires_benevole_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formulaires_benevole/edit.html.twig', [
            'formulaire' => $formulaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formulaires_benevole_delete', methods: ['POST'])]
    public function delete(Request $request, Formulaires $formulaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formulaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formulaires_benevole_index', [], Response::HTTP_SEE_OTHER);
    }
}
