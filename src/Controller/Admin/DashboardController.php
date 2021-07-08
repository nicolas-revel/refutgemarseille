<?php

namespace App\Controller\Admin;

use App\Entity\Adress;
use App\Entity\Cart;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Review;
use App\Entity\Stock;
use App\Entity\Tag;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller\Admin
 */
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index (): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        return $this->redirect($routeBuilder->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard (): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Le Re[fût]ge Marseille');
    }

    public function configureMenuItems (): iterable
    {
        return [
            MenuItem::section("Gestion utilisateurs", "fa fa-group"),
            MenuItem::linkToCrud("Utilisateurs", "fa fa-user", User::class),
            MenuItem::linkToCrud("Adresses", "fa fa-map", Adress::class),
            MenuItem::linkToCrud("Avis", "fa fa-comment", Review::class),
            MenuItem::linkToCrud("Panier", "fa fa-shopping-cart", Cart::class),


            MenuItem::section("Boutique", "fa fa-euro"),
            MenuItem::linkToCrud("Produits", "fa fa-beer", Product::class),
            MenuItem::linkToCrud("Stocks", "fa fa-boxes", Stock::class),
            MenuItem::linkToCrud("Commandes", "fa fa-truck", Order::class),
            MenuItem::linkToCrud("Catégories", "fa fa-sitemap", Category::class),
            MenuItem::linkToCrud("Hashtags", "fa fa-hashtag", Tag::class)

        ];
    }

    public function configureCrud (): Crud
    {
        return Crud::new()
            ->setDateFormat('dd/MM/yyyy')
            ->setDateTimeFormat('dd/MM/yyyy HH:mm')
            ->setPaginatorPageSize(10);
    }
}
