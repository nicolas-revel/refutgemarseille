<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAdresseType extends AbstractType
{
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre de l'adresse",
                "required" => false,
            ])
            ->add('country', TextType::class, [
                "label" => "Pays :",
                "required" => true,
            ])
            ->add('city', TextType::class, [
                "label" => "Ville :",
                "required" => true,
            ])
            ->add('postalCode', TextType::class, [
                "label" => "Code Postal :",
                "required" => true,
            ])
            ->add('street', TextType::class, [
                "label" => "Rue :",
                "required" => true,
            ])
            ->add('optionnal1', TextType::class, [
                "label" => "Complément 1 :",
                "required" => false,
            ])
            ->add('optionnal2', TextType::class, [
                "label" => "Complément 2:",
                "required" => false,
            ])
            ->add('number', NumberType::class, [
                "label" => "Numéro de rue :",
                "required" => true,
                "invalid_message" => "Merci d'indiquer une valeur numérique uniquement"
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Confirmer",
            ])
        ;
    }

    public function configureOptions (OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
