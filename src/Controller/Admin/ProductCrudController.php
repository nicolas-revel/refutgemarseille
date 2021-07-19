<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud (Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular("Produit")
            ->setEntityLabelInPlural("Produits");
    }

    public function createEntity (string $entityFqcn)
    {
        $product = new Product();
        $product->setCreatedAt(new DateTime("now"));
        if ($product->getReleasedAt() === null) {
            $product->setReleasedAt(new DateTime("now"));
        }

        return $product;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', "ID")->hideOnForm(),
            TextField::new('name', "Nom"),
            SlugField::new("slug", "Slug")->setTargetFieldName("name")->hideOnIndex(),
            DateTimeField::new("released_at", "Date de sortie")->setValue("now")->setRequired(true),
            TextEditorField::new("description","Description"),
            NumberField::new("price", "Prix")->setNumDecimals(2),
            IntegerField::new("stock", "Stocks"),
            TextField::new("image1File", "Image 1")->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image1')->setBasePath('/uploads/images/products')->onlyOnIndex(),
            TextField::new("image2File", "Image 2")->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image2')->setBasePath('/uploads/images/products')->onlyOnIndex(),
            TextField::new("image3File", "Image 3")->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('image3')->setBasePath('/uploads/images/products')->onlyOnIndex(),
            AssociationField::new("category", "Catégorie")->setRequired(true),
            AssociationField::new("tags", "Hashtags"),
            ];
    }
}
