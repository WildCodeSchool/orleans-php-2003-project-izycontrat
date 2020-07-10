<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class LawyerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'label' => 'Civilité',
                'choices' => [
                    'Homme' => 2,
                    'Femme' => 1
                ],
                'required' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'mapped' => true,
                'empty_data' => null,
                'attr' => array(
                    'placeholder' => 'Louis',
                ),
                'required' => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'mapped' => true,
                'empty_data' => null,
                'attr' => array(
                    'placeholder' => 'Dupons',
                ),
                'required' => false,
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Téléphone',
                'mapped' => true,
                'empty_data' => null,
                'attr' => array(
                    'placeholder' => '0X XX XX XX XX',
                ),
                'required' => false,
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'mapped' => true,
                'empty_data' => null,
                'attr' => array(
                    'placeholder' => '15 rue de la patte d\'oie 78000 Versailles',
                ),
                'required' => false,
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'mapped' => true,
                'empty_data' => null,
                'preferred_choices' => array('FR'),
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le Pays ne doit pas être vide.',
                    ]),
                ],
            ])
            ->add('specialization', ChoiceType::class, [
                'label' => 'Spécialité',
                'choices' => [
                    'Aucun' => null,
                    'Droit des personnes',
                    'Droit pénal' => 'Droit pénal',
                    'Droit immobilier' => 'Droit immobilier',
                    'Droit rural' => 'Droit rural',
                    'Droit de l’environnement' => 'Droit de l’environnement',
                    'Droit public' => 'Droit public',
                    'Droit de la propriété intellectuelle' => 'Droit de la propriété intellectuelle',
                    'Droit commercial' => 'Droit commercial',
                    'Droit des sociétés' => 'Droit des sociétés',
                    'Droit fiscal' => 'Droit fiscal',
                    'Droit social' => 'Droit social',
                    'Droit économique' => 'Droit économique',
                    'Droit des mesures d’exécution' => 'Droit des mesures d’exécution',
                    'Droit communautaire' => 'Droit communautaire',
                    'Droit international' => 'Droit international'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
