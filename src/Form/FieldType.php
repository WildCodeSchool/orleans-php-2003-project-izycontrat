<?php

namespace App\Form;

use App\Entity\Field;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldType extends AbstractType
{
    private $entities;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->entities = $options['entities'];
        $builder
            ->add('label', TextType::class, [
                'label' => 'Nom du Champ',
                'mapped' => true,
            ])
            ->add('entity', ChoiceType::class, [
                'label' => 'Entité',
                'mapped' => false,
                'required' => false,
                'choices' => $this->entities->listTables(),
                'choice_label' => function ($entity) {
                    return $entity ? $entity->getName() : '';
                },
                'choice_value' => function ($entity) {
                    return $entity ? $entity->getName() : '';
                },
            ])
            ->add('fieldName', ChoiceType::class, [
                'label' => 'Champ',
                'choices' => null,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Field::class,
            'entities' => null,
        ]);
    }
}
