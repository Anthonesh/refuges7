<?php

namespace App\Form;

use App\Entity\Benevolat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class BenevolatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('heure_debut_benevolat', DateTimeType::class, [
                'label' => 'Début bénévolat',
                'date_widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "L'heure de début est obligatoire",
                    ]),
                ],
            ])
            ->add('heure_fin_benevolat', DateTimeType::class, [
                'label' => 'Fin bénévolat',
                'date_widget' => 'single_text',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "L'heure de fin est obligatoire",
                    ]),
                ],
            ])
            ->add('nombre_total_benevolat', IntegerType::class, [
                'label' => 'Places disponibles',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nombre de participants est obligatoire.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Benevolat::class,
        ]);
    }
}
