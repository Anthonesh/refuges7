<?php

namespace App\Controller;

use App\Entity\Jours;
use App\Entity\Heures;
use App\Entity\Reservations;
use App\Form\ReservationBenevoleType;
use App\Repository\CalendrierRepository;
use App\Repository\PensionnairesRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class BenevolatController extends AbstractController
{
    #[Route('/benevolat', name: 'app_benevolat')]
    public function index(PensionnairesRepository $pensionnairesRepository,CalendrierRepository $calendrierRepo,
    ReservationService $reservationService): Response {
        
        //récupère les informations évènements depuis le répository
        $events = $calendrierRepo->findAll();
        //Déclare un tableau évènements vide
        $evts = [];
// Transforme les données des événements pour les rendre compatibles avec l'affichage
        foreach ($events as $event) {
        
            // Stockez les informations de l'événement avec les informations des formulaires
            $evts[] = [
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

        return $this->render('evenementiel/index.html.twig', [
            'controller_name' => 'EvenementielController',
            'events' => $evts,
            'pensionnaires' => $pensionnaires,
        ]);
    }

    #[Route('/benevolat/reserver/{id}', name: 'app_benevolat_reserver')]
    public function reserver(Request $request,PensionnairesRepository $pensionnairesRepository,CalendrierRepository $calendrierRepo,
    ReservationService $reservationService,$id): Response {

        // Trouve l'événement à réserver par son ID
        $calendrier = $calendrierRepo->find($id);

        // Crée une nouvelle réservation
        $reservation = new Formulaires();
        $form = $this->createForm(FormulairesType::class, $reservation);
        $form->handleRequest($request);
    
        // Vérifie si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                // Tente d'effectuer la réservation
                $reservationService->effectuerReservation($calendrier, $reservation);
                // Message de succès
                $this->addFlash('success', 'Réservation effectuée avec succès.');
            } catch (\Exception $e) {
                // Gère les erreurs éventuelles
                $this->addFlash('error', $e->getMessage());
            }
            // Redirige vers la page principale de l'événementiel
            return $this->redirectToRoute('app_evenementiel');
        }
        $pensionnaires = $pensionnairesRepository->findAll();

        return $this->render('calendrier/new.html.twig', [
            'form' => $form->createView(),
            'pensionnaires' => $pensionnaires,
        ]);
    }
}
