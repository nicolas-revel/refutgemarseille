<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud (Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular("Utilisateur")
            ->setEntityLabelInPlural("Utilisateurs");
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new("id", "ID")->setSortable(true)->hideOnForm(),
            EmailField::new("email", "Email")->setSortable(true),
            BooleanField::new("verified", "Vérifié"),
            ArrayField::new("roles", "Rôles"),
            TextField::new("firstname", "Prénom")->setSortable(true),
            TextField::new("lastname", "Nom")->setSortable(true),
            DateField::new("birthdate", "Date de naissance"),
            TelephoneField::new("phone_number", "Numéro de téléphone")
        ];
    }

}
