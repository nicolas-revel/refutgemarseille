<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\Cart;
use App\Entity\CartHasProduct;
use App\Entity\Product;
use App\Form\AddAdresseType;
use App\Form\CartType;
use App\Form\ProductToCartType;
use Error;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     * @IsGranted("ROLE_USER")
     */
    public function index (Request $request): Response
    {
        if ($this->getUser()) {
            /** @var Cart $cart */
            $cart = $this->getUser()->getCart();
            $cartHasProduct = $cart->getCartHasProducts()->getValues();
            $totalAmount = 0;
            foreach ($cartHasProduct as $product) {
                $products[] = $product->getProduct();
                $totalAmount += $product->getAmount();
            }
            $cart->setTotalAmount($totalAmount);
        } else {
            $cart = null;
        }
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $cart = $form->getData();
            $cart->setTotalAmount(0);
            $totalAmount = 0;
            foreach ($cart->getCartHasProducts() as $cartItem) {
                $cartItem->setAmount($cartItem->getQuantity() * $cartItem->getPrice());
                dump($cartItem->getAmount());
                $totalAmount += $cartItem->getAmount();
                dump($totalAmount);
            }
            $cart->setTotalAmount($totalAmount);
            $this->getDoctrine()->getManager()->persist($cart);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($request->getUri());

        }
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/cart/adress", name="adresse")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function adresse (Request $request): Response
    {
        $form = $this->createForm(AddAdresseType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Adress $adress */
            $adress = $form->getData();
            $adress->setUser($this->getUser());
            $this->getDoctrine()->getManager()->persist($adress);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("checkout");
        }

        return $this->render('cart/adresse.html.twig', [
            'controller_name' => 'CartController',
            "form_adress" => $form->createView(),
        ]);
    }

    /**
     * @Route ("/cart/checkout", name="payment")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @return Response
     */
    public function checkout(Request $request) : Response {
        return $this->render("cart/checkout.html.twig", [
            "controller_name" => "CartController",
        ]);
    }
}
