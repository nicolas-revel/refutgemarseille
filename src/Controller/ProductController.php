<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartHasProduct;
use App\Entity\ProductSearch;
use App\Entity\User;
use App\Form\ProductSearchType;
use App\Form\ProductToCartType;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/shop", name="shop")
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
    public function show (string $slug, Request $request): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Cart $cart */
        $cart = $user->getCart();
        $product = $this->getDoctrine()->getRepository("App:Product")->findOneBy(['slug' => $slug]);
        if (!$cart) {
            $newcart = new Cart();
            $newcart->setUser($user)->setCreatedAt(new DateTime());
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newcart);
            $manager->flush();
            $cart = $user->getCart();
        }
        if (!$this->getDoctrine()->getRepository("App:CartHasProduct")->findOneBy([
            "cart" => $cart->getId(),
            "product" => $product->getId(),
        ])) {
            $cartRow = new CartHasProduct();
            $cartRow->setCart($cart)->setProduct($product);
        } else {
            $cartRow = $this->getDoctrine()->getRepository("App:CartHasProduct")->findOneBy([
                "cart" => $cart->getId(),
                "product" => $product->getId(),
            ]);
        }
        $cart_form = $this->createForm(ProductToCartType::class, $cartRow);
        $cart_form->handleRequest($request);
        if ($cart_form->isSubmitted() && $cart_form->isValid()) {
            /** @var CartHasProduct $cartRow */
            $cartRow = $cart_form->getData();
            if ($cartRow->getQuantity() > $product->getStock()) {
                $this->addFlash("alert", "Merci d'indiquer une quantité inférieur ou égale au stock du produit");
            } else {
                $cartRow
                    ->setAmount($cartRow->getQuantity() * $product->getPrice())
                    ->setImage($product->getImage1())
                    ->setCategory($product->getCategory())
                    ->setPrice($product->getPrice())
                    ->setSlug($product->getSlug());
                $this->getDoctrine()->getManager()->persist($cartRow);
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute("shop");
            }
        }
        return $this->render("product/show.html.twig", [
            'controller_name' => 'ProductController',
            "product" => $product,
            "cart_form" => $cart_form->createView(),
        ]);
    }
}
