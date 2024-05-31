<?php

namespace App\Form;

use App\Entity\Benevolat;
use App\Entity\Calendrier;
use App\Entity\Formulaires;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulairesBenevolatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_formulaire')
            ->add('prenom_formulaire')
            ->add('telephone_formulaire')
            ->add('email_formulaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formulaires::class,
        ]);
    }
}
