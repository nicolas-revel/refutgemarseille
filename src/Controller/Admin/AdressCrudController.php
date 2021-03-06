<?php

namespace App\Controller\Admin;

use App\Entity\Adress;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Adress::class;
    }

    public function configureCrud (Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular("Adresse")
            ->setEntityLabelInPlural("Adresses");
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
