<?php

namespace App\Controller;

use App\Entity\Cart;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CheckoutController extends AbstractController
{
    /**
     * @Route("/checkout", name="checkout")
     */
    public function index (): Response
    {
        Stripe::setApiKey("sk_test_51JEZQMH14JX7sMEUPolvePOpwQl1zuce5cwU0h3ySYVZdxhXcw9Rh3QtqLCR7jBUiHg7byqKl0NVjNc1d5zuVaWL00LlZuQPBn");
        /** @var Cart $cart */
        $cart = $this->getUser()->getCart();
        $totalAmount = $cart->getTotalAmount() * 100;
        header('Content-Type: application/json');
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount,
                'currency' => 'eur',
            ]);
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }

    /**
     * @Route("/checkout_success", name="checkout_success")
     */
    public function success () {
        return $this->render('checkout/success.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }

    /**
     * @Route("/checkout_error", name="checkout_error")
     */
    public function error () {
        return $this->render('checkout/error.html.twig', [
            'controller_name' => 'CheckoutController',
        ]);
    }
}
