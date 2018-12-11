<?php

namespace App\Form;

use App\Entity\{
    Option,
    PropertySearch
};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\{AbstractType,
    Extension\Core\Type\ChoiceType,
    Extension\Core\Type\HiddenType,
    Extension\Core\Type\TextType,
    FormBuilderInterface};
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget maximum'
                ]
            ])
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface minimale'
                ]
            ])
            ->add('options', EntityType::class, [
                'required' => false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true

            ])
            ->add('address', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('distance', ChoiceType::class, [
                'label' => false,
                'required' => false,
                'choices' => [
                    '10 km' => 10,
                    '1000 km' => 1000,
                ]
            ])
            ->add('lat', HiddenType::class)
            ->add('lng', HiddenType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            // Method of research is GET, not POST
            'method' => 'get',
            // No need of csrf token to make a search
            'csrf_protection' => false
        ]);
    }

    /**
     * To change URL writting really much cleaner
     */
    public function getBlockPrefix()
    {
        return;
    }
}
