<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'attr' => [
                    'placehpolder' => 'Enter city name',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'The city field cannot be empty.']),
                ],

        ])
        ->add('country', ChoiceType::class, [
            'choices' => [
                'Poland' => 'PL',
                'Germany' => 'DE',
                'France' => 'FR',
                'Spain' => 'ES',
                'Italy' => 'IT',
                'United Kingdom' => 'GB',
                'United States' => 'US',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
