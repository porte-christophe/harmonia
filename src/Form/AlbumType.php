<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('jacket', FileType::class, [
                'label' => 'Jacket :',
                // unmapped means that this field is not associated with any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the file
                // every time you edit the Album details
                'required' => false,
            ])

            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'EP' => 'EP',
                    'Album' => 'Album',
                    'Single' => 'Single',
                ],
            ])
            ->add('releaseDate', null, [
                'widget' => 'single_text'
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'artistName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
