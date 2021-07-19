<?php

namespace App\Form;

use App\Entity\Cart;
use App\Entity\CartHasProduct;
use App\EventSubscriber\ClearCartSubscriber;
use App\EventSubscriber\RemoveCartItemSubscriber;
use App\EventSubscriber\UpdateCartHasProductSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cartHasProducts', CollectionType::class, [
                'entry_type' => CartProductType::class
            ])
            ->add('clear', SubmitType::class, [
                "label" => "Vider le panier"
            ])
        ;
        $builder->addEventSubscriber(new RemoveCartItemSubscriber());
        $builder->addEventSubscriber(new ClearCartSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cart::class,
        ]);
    }
}
