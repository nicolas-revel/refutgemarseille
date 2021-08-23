<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $latestProduct = $this->getDoctrine()->getRepository("App:Product")->findLatestProcuct();
        $preoderProduct = $this->getDoctrine()->getRepository("App:Product")->findPreorderProduct();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "latestProduct" => $latestProduct,
            "preorderProduct" => $preoderProduct,
        ]);
    }
}
