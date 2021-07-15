<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartHasProduct;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        if ($this->getUser()) {
            /** @var Cart $cart */
            $cart = $this->getUser()->getCart();
            $cartHasProduct = $cart->getCartHasProducts()->getValues();
            foreach ($cartHasProduct as $product) {
                $products[] = $product->getProduct();
            }
        } else {
            $cart = null;
            $cartHasProduct = null;
            $products = null;
        }
        /** @var CartHasProduct|null $cartHasProduct */
        /** @var Cart|null $cart */
        /** @var Product[]|null $products */
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            'products' => $products,
            'cartHasProduct' => $cartHasProduct,
        ]);
    }
}
