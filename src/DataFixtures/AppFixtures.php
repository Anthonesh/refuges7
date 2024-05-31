<?php

namespace App\DataFixtures;
use App\Entity\InformationsPensionnaires;
use App\Entity\Pensionnaires;
use App\Entity\Reservations;
use App\Entity\Jours;
use App\Entity\Heures;
use App\Entity\Utilisateurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        //Creation d'utilisateurs
        $adminUser = $this->createUtilisateurs("admin@refuge.com",["ROLE_ADMIN"], "123456789", "Rusch",  "Juelin", "0745321695",  $manager);


        // //Création du planning
        // $joursSemaine = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        
        // foreach ($joursSemaine as $jour) {
        //     $jours = new Jours();
        //     $jours->setJourSemaine($jour);
        //     $manager->persist($jours);
        // }
        
        // $manager->flush();
        
        // $heuresDebut = ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00'];
        // $heuresFin = ['08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'];
        
        // foreach ($heuresDebut as $key => $heureDebut) {
        //     $heureFin = $heuresFin[$key];
        
        //     $plageHoraire = new Heures();
        //     $plageHoraire->setHeureDebut(new \DateTime($heureDebut));
        //     $plageHoraire->setHeureFin(new \DateTime($heureFin));
        //     $manager->persist($plageHoraire);
        // }

        
        // // Créez ici des réservations fictives, par exemple :
        // $plageHoraire = $manager->getRepository(Heures::class)->findOneBy(['heureDebut' => new \DateTime('08:00')]);
        
        // $reservation = new Reservations();
        // $reservation->setHeure($plageHoraire);
        // // Définissez d'autres propriétés de réservation si nécessaire
        // $manager->persist($reservation);
        
        // $manager->flush();

        //Pensionnaires data

        $nomsPensionnaires = [
            'Cabaretune', 'Halfen', 'Jappeloup', 'Jesty', 'Jojo', 'Julie', "Lenthier d'Y",
            'Léon', 'Lila', 'Mambo', 'Mistral', 'Ninja', 'Pepsi', 'Petite fleur', 'Qaida', 'Rolls', 'Tommy', 'Zoe'
        ];

        $typesDeCheval = ['Poney', 'Cheval de selle', 'Cheval de course', 'Pur-sang', 'Trait'];

        $images = [
            'Images\cards\Cabaretune.webp', 'Images\cards\Halfen.webp', 'Images\cards\Jappeloup.webp', 'Images\cards\Jesty.webp', 'Images\cards\Jojo.webp',
            'Images\cards\Julie.webp', "Images\cards\Lenthier d'Y.webp", 'Images\cards\Léon.webp', 'Images\cards\Lila.webp', 'Images\cards\Mambo.webp', 
            'Images\cards\Mistral.webp', 'Images\cards\Ninja.webp', 'Images\cards\Pepsi.webp', 'Images\cards\Petite_fleur.webp', 'Images\cards\Qaida.webp',
            'Images\cards\Rolls.webp', 'Images\cards\Tommy.webp', 'Images\cards\Zoé.webp'
        ];

        $imageIndex = 0;

        foreach ($nomsPensionnaires as $nom) {
            $pensionnaire = new Pensionnaires();
            $pensionnaire->setNomPensionnaire($nom);
            $pensionnaire->setTypePensionnaire($typesDeCheval[array_rand($typesDeCheval)]);
            $pensionnaire->setDateDeNaissancePensionnaire(new \DateTime('-' . mt_rand(1, 20) . ' years'));
            
            // Attribuer une image au pensionnaire en utilisant le compteur
            $pensionnaire->setImagePensionnaire($images[$imageIndex]);
        
            // Incrémenter le compteur pour passer à l'image suivante
            $imageIndex++;
        
            // Assurez-vous que le compteur ne dépasse pas la taille du tableau
            if ($imageIndex >= count($images)) {
                $imageIndex = 0; // Revenir au début du tableau si nécessaire
            }


            $manager->persist($pensionnaire);
        }

        $manager->flush();

        $pensionnaires = $manager->getRepository(Pensionnaires::class)->findAll();

        foreach ($pensionnaires as $pensionnaire) {
            $infosPensionnaire = new InformationsPensionnaires();
            $infosPensionnaire->setPensionnaire($pensionnaire);
            $infosPensionnaire->setNourritureInformationPensionnaire('Information sur la nourriture');
            $infosPensionnaire->setSoinInformationPensionnaire('Information sur les soins');
            $infosPensionnaire->setCarnetDeSanteInformationPensionnaire('Information sur le carnet de santé');
            $infosPensionnaire->setHistoireInformationPensionnaire('Histoire du pensionnaire');
            // Ajoutez d'autres propriétés si nécessaire

            $manager->persist($infosPensionnaire);
        }

        $manager->flush();

    }

    public function createUtilisateurs($Email, $arrRoles, $Password, $Nom, $Prenom, $Telephone,  ObjectManager $manager): Utilisateurs
    {
        $user = new Utilisateurs();
        $user->setEmail($Email);
        $user->setRoles($arrRoles);
        $user->setPassword(password_hash($Password, PASSWORD_BCRYPT));
        $user->setNomUtilisateur($Nom);
        $user->setPrenomUtilisateur($Prenom);
        $user->setNumeroTelephoneUtilisateur($Telephone);


        $manager->persist($user);

        // $this->setReference('utilisateurs-' . $this->counter, $user);
        // $this->counter++;
        
        return $user;
    }
}