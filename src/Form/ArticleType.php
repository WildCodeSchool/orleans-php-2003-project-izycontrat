<?php

namespace App\Form;

use App\Entity\Article;
use FM\ElfinderBundle\ElFinder\ElFinder;
use FM\ElfinderBundle\Form\Type\ElFinderType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Titre de l\'article'])
            ->add('imageFile', ElFinderType::class, [
                'mapped' => true,
                'required' => false,
                'instance'=>'form',
                'label' => 'Image de couverture',
                'enable'=>true])
            ->add('text', CKEditorType::class, [
                'config_name' => 'article',
                'label' => 'Article'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
