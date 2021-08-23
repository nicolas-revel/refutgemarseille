<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use DateTime;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud (Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular("Catégorie")
            ->setEntityLabelInPlural("Catégories");
    }

    public function createEntity (string $entityFqcn)
    {
        $category = new Category();
        $category->setCreatedAt(new DateTime("now"));

        return $category;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id", "ID")->hideOnForm()->setSortable(true),
            TextField::new("name", "Nom catégorie")->setSortable(true),
            TextField::new("imageFile")->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image')->setBasePath("/uploads/images/categories/")->onlyOnIndex(),
        ];
    }

}
