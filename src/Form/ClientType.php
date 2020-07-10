<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Louis',
                ),
                'required'    => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => 'Dupons',
                ),
                'required'    => false,
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Téléphone',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => '0X XX XX XX XX',
                ),
                'required'    => false,
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Adresse',
                'mapped' => true,
                'empty_data'  => null,
                'attr' => array(
                    'placeholder' => '15 rue de la patte d\'oie 78000 Versailles',
                ),
                'required'    => false,
            ])
            ->add('country', CountryType::class, [
                'label' => 'Pays',
                'mapped' => true,
                'empty_data'  => null,
                'preferred_choices' => array('FR'),
                'required'    => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le Pays ne doit pas être vide.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
