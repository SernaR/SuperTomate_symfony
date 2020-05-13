<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Category;
use App\Entity\Difficulty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('serve')
            ->add('making')
            ->add('cook')
            ->add('wait')
            ->add('imageFile', FileType::class, ['required'=> false])
            ->add('category', EntityType::class, [
                'class'=> Category::class,
                'choice_label'=>'name'
            ])
            ->add('difficulty', EntityType::class, [
                'class'=> Difficulty::class,
                'choice_label'=>'name'
            ])
            ->add('ingredients', CollectionType::class, [
                'entry_type' => IngredientType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('steps', CollectionType::class, [
                'entry_type' => StepType::class,
                'entry_options' => ['label' => false],
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Ajouter ma recette'])
            ->add('saveDraft', SubmitType::class, ['label' => 'Enregistrer le brouillon']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
