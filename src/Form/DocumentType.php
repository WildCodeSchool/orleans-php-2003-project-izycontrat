<?php

namespace App\Form;

use App\Entity\Document;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fileName', TextType::class, [
                'label' => 'Nom du document',
                'mapped' => true,
                'required' => true,
            ])
            ->add('content', CKEditorType::class, [
                'config' => array(
                    'toolbar' => 'Documents',
                    'customConfig' => '/build/documentJs.js',
                ),
                'label' => false,
                'mapped' => true,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
