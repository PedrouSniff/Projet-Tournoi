<?php

namespace App\Form;

use App\Entity\type;
use App\Entity\Tournoi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

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
        // Champ pour télécharger l'image
        ->add('image', FileType::class, [
            'label' => 'Image (JPG, PNG, GIF)',
            'mapped' => false,  // Cela signifie que ce champ ne sera pas lié directement à la propriété 'image' dans l'entité
            'required' => false,
            'constraints' => [
                new File([
                    'maxSize' => '5M',  // Taille maximale de 5 Mo
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                    ],
                    'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG, PNG, GIF).',
                ])
            ],
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
