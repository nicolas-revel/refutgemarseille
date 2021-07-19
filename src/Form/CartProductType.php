<?php

namespace App\Form;

use App\Entity\CartHasProduct;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', NumberType::class, [
                "label" => "Quantité"
            ])
            ->add('update', SubmitType::class, [
                "label" => "Modifier"
            ])
            ->add('remove', SubmitType::class, [
                "label" => "Supprimer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CartHasProduct::class,
        ]);
    }
}
