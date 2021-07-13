<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\ProductSearch;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductSearchType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('query', SearchType::class, [
                "required" => false,
                "label" => false,
                "attr" => [
                    "placeholder" => "Rechercher un produit ..."
                ]
            ])
            ->add("preorder", CheckboxType::class, [
                "required" => false,
                "label" => "Précommande"
            ])
            ->add('categories', EntityType::class, [
                "label" => "Catégories :",
                "required" => false,
                "class" => Category::class,
                "expanded" => true,
                "multiple" => true
            ])
            ->add('tags', EntityType::class, [
                "label" => "Tags :",
                "required" => false,
                "class" => Tag::class,
                "expanded" => true,
                "multiple" => true
            ]);
    }

    public function configureOptions (OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductSearch::class,
            "method" => "get",
            'csrf_protection' => false
        ]);
    }

    /**
     * @return string|null
     */
    public function getBlockPrefix (): ?string
    {
        return '';
    }
}
