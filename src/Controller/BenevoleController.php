<?php

namespace App\Controller;

use App\Entity\Benevolat;
use App\Entity\Formulaires;
use App\Form\BenevolatType;
use App\Form\FormulairesBenevolatType;
use App\Repository\BenevolatRepository;
use App\Repository\CalendrierRepository;
use App\Repository\PensionnairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BenevoleController extends AbstractController
{
    #[Route('/benevole', name: 'app_benevole')]
    
    public function index(BenevolatRepository $benevolatRepo, CalendrierRepository $calendrierRepository, PensionnairesRepository $pensionnairesRepository): Response
    {
        $benevolats = $benevolatRepo->findAll();
        $data = [];

        foreach ($benevolats as $benevolat) {
            $data[] = [
                'id' => $benevolat->getId(),
                'start' => $benevolat->getHeureDebutBenevolat()->format('Y-m-d H:i:s'),
                'end' => $benevolat->getHeureFinBenevolat()->format('Y-m-d H:i:s'),
                'placesDisponibles' => $benevolat->getNombreTotalBenevolat(),
            ];
        }

         // Récupérer les événements du calendrier événementiel depuis le repository
        $eventCalendarEvents = $calendrierRepository->findAll();

         // Formatter les événements du calendrier événementiel pour les intégrer dans le calendrier bénévole
        foreach ($eventCalendarEvents as $event) {
            $events[] = [
                'id' => $event->getId(),
                'titre_calendrier' => htmlspecialchars($event->getTitreCalendrier()),
                'debut_calendrier' => $event->getDebutCalendrier()->format('Y-m-d H:i:s'),
                'fin_calendrier' => $event->getFinCalendrier()->format('Y-m-d H:i:s'),
                'description_calendrier' => $event->getDescriptionCalendrier(),
                'couleur_fond_calendrier' => $event->getCouleurFondCalendrier(),
                'couleur_bordure_calendrier' => $event->getCouleurBordureCalendrier(),
                'couleur_texte_calendrier' => $event->getCouleurTexteCalendrier(),
                'places_disponibles_calendrier' => $event->getPlacesDisponiblesCalendrier(),
            ];
        }

        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('benevole/index.html.twig', [
            'events' => $data,
            'pensionnaires' => $pensionnaires
        ]);
    }

    #[Route('/benevole/reserver', name: 'app_benevole_reserver', methods: ['GET', 'POST'])]
    public function benevolat(Request $request, EntityManagerInterface $entityManager): Response
    {
    // Récupérer les données du créneau horaire de la requête POST
    $heureDebut = $request->request->get('heure_debut');
    $heureFin = $request->request->get('heure_fin');
    $nombreParticipants = $request->request->get('nombre_participants');
    $date = $request->request->get('date');

    // Créer une nouvelle instance de Benevolat et y stocker les données du créneau horaire
    $benevolat = new Benevolat();
    $benevolat->setHeureDebutBenevolat(new \DateTime($date . ' ' . $heureDebut));
    $benevolat->setHeureFinBenevolat(new \DateTime($date . ' ' . $heureFin));
    $benevolat->setNombreTotalBenevolat($nombreParticipants);

    // Persister l'entité Benevolat
    $entityManager->persist($benevolat);
    $entityManager->flush();

    // Rediriger l'utilisateur vers la page suivante avec les paramètres dans l'URL
    $url = $this->generateUrl('app_formulaires_benevole_new', [
        'date' => $date,
        'heure_debut' => $heureDebut,
        'heure_fin' => $heureFin,
        'nombre_participants' => $nombreParticipants
    ]);

    return $this->redirect($url);
    }

    #[Route('/benevole/personal-data/{id}', name: 'app_benevole_personal_data', methods: ['GET', 'POST'])]
    public function personalData(Request $request, EntityManagerInterface $entityManager, Formulaires $formulaire): Response
    {
        $form = $this->createForm(FormulairesBenevolatType::class, $formulaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Réservation effectuée avec succès.');
            return $this->redirectToRoute('app_benevole');
        }

        return $this->render('benevole/personal_data.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
