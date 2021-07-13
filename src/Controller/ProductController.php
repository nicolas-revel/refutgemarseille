<?php

namespace App\Controller;

use App\Entity\ProductSearch;
use App\Entity\User;
use App\Form\ProductSearchType;
use App\Form\ProductToCartType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 */

class ProductController extends AbstractController
{
    /**
     * @Route("/shop", name="product")
     */
    public function index (PaginatorInterface $paginator, Request $request): Response
    {
        $search = new ProductSearch();
        $form = $this->createForm(ProductSearchType::class, $search);
        $form->handleRequest($request);
        $products = $paginator->paginate(
            $this->getDoctrine()->getRepository("App:Product")->findAllFiltered($search),
            $request->query->getInt("page", 1),
            20
        );
        return $this->render('product/shop.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/shop/{slug}", name="product_path")
     *
     * @param string $slug
     * @param Request $request
     * @return Response
     */
    public function show(string $slug, Request $request) : Response
    {
        $user = $this->getUser();
        $cart = $this->getDoctrine()->getRepository("App:Cart")->findOneBy(['user' => 64]);
        dd($cart);
        $product = $this->getDoctrine()->getRepository("App:Product")->findOneBy(['slug' => $slug]);
        $cart_form = $this->createForm(ProductToCartType::class, $product);
        $cart_form->handleRequest($request);
        return $this->render("product/show.html.twig", [
            "product" => $product,
            "cart_form" => $cart_form->createView(),
        ]);
    }
}
