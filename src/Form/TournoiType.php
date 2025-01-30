<?php

namespace App\Form;

use App\Entity\Tournoi;
use App\Entity\type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournoiType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('status')
            //->add('created_at', null, [
               // 'widget' => 'single_text',
            //])
            //->add('created_by')
            ->add('type', EntityType::class, [
                'class' => type::class,
                'choice_label' => 'typetournoi',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tournoi::class,
        ]);
    }
}
