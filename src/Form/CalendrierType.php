<?php

namespace App\Form;

use App\Entity\Calendrier;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CalendrierType extends AbstractType
{
    /**
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre_calendrier', TextType::class, [
            // Définit le texte affiché à l'utilisateur
            'label' => 'Titre de l\'événement', 
            // Indique que ce champ doit être rempli pour soumettre le formulaire
            'required' => true, 
            //S'assure que la valeur n'est pas vide
            'constraints' => [
                new NotBlank([
                    'message' => 'Le titre est obligatoire.',
                ]),
            ],
        ])
        ->add('debut_calendrier', DateTimeType::class, [
            'label' => 'Début de l\'événement',
            'date_widget' => 'single_text',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le date/heure de début est obligatoire',
                ]),
            ],
        ])
        ->add('fin_calendrier', DateTimeType::class, [
            'label' => 'Fin de l\'événement',
            'date_widget' => 'single_text',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le date/heure de fin est obligatoire.',
                ]),
            ],
        ])
        ->add('description_calendrier', TextType::class, [
            'label' => 'Description',
        ])
        ->add('couleur_fond_calendrier', ColorType::class, [
            'label' => 'Couleur de fond',
        ])
        ->add('couleur_bordure_calendrier', ColorType::class, [
            'label' => 'Couleur de la bordure',
        ])
        ->add('couleur_texte_calendrier', ColorType::class, [
            'label' => 'Couleur du texte',
        ])
        ->add('places_disponibles_calendrier', IntegerType::class, [
            'label' => 'Places disponibles',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nombre de place est obligatoire.',
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calendrier::class,
        ]);
    }
}
