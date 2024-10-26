<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\WeatherConditions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;

class WeatherConditionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', null, [
                'widget' => 'single_text',
                'attr' => ['placeholder' => 'Select a date'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'The date field cannot be empty.']),

                ],
            ])
            ->add('celsius', null, [
                'attr' => ['placeholder' => 'Enter temperature in °C'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Temperature is required.']),
                    new Assert\Range([
                        'min' => -100,
                        'max' => 100,
                        'notInRangeMessage' => 'Temperature must be between -50°C and 60°C.',
                    ]),
                ],
            ])
            ->add('is_rain', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'placeholder' => 'Is it raining?',
                'constraints' => [
                    new Assert\NotNull(['message' => 'Please specify if it is raining.']),
                ],
            ])
            ->add('rain_predict', null, [
                'attr' => ['placeholder' => 'Enter rain prediction (%)'],
                'constraints' => [
                    new Assert\Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Rain prediction must be between 0% and 100%.',
                    ]),
                ],
            ])
            ->add('wind', ChoiceType::class, [
                'choices' => [
                    'Yes' => true,
                    'No' => false,
                ],
                'placeholder' => 'Is wind?',
                'constraints' => [
                    new Assert\NotNull(['message' => 'Please specify if there is wind.']),
                ],
            ])
            ->add('wind_power', null, [
                'attr' => ['placeholder' => 'Enter wind power'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Wind power is required.']),
                ],
            ])
            ->add('wind_direction', ChoiceType::class, [
                'choices' => [
                    'North' => 'N',
                    'East' => 'E',
                    'South' => 'S',
                    'West' => 'W',
                    'Northeast' => 'NE',
                    'Northwest' => 'NW',
                    'Southeast' => 'SE',
                    'Southwest' => 'SW',
                ],
                'placeholder' => 'Select wind direction',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Wind direction is required.']),
                ],
            ])
            ->add('conditions', ChoiceType::class, [
                'choices' => [
                    'Clear' => 'clear',
                    'Cloudy' => 'cloudy',
                    'Rainy' => 'rainy',
                    'Stormy' => 'stormy',
                    'Snowy' => 'snowy',
                ],
                'placeholder' => 'Select weather condition',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please select the weather condition.']),
                ],
            ])
            ->add('humidity', null, [
                'attr' => ['placeholder' => 'Enter humidity level (%)'],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Humidity level is required.']),
                    new Assert\Range([
                        'min' => 0,
                        'max' => 100,
                        'notInRangeMessage' => 'Humidity must be between 0% and 100%.',
                    ]),
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'placeholder' => 'Select location',
                'constraints' => [
                    new Assert\NotNull(['message' => 'Location is required.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WeatherConditions::class,
        ]);
    }
}
