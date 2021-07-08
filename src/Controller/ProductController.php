<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $repository;

    private ObjectManager $entityManager;

    /**
     * ProductController constructor.
     * @param ProductRepository $repository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct (ProductRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/shop", name="product")
     */
    public function index (PaginatorInterface $paginator, Request $request): Response
    {
        $products = $paginator->paginate(
            $this->getRepository()->findReleased(),
            $request->query->getInt("page", 1),
            20
        );
        dump($products);
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    /**
     * @return ProductRepository
     */
    public function getRepository (): ProductRepository
    {
        return $this->repository;
    }

    /**
     * @param ProductRepository $repository
     */
    public function setRepository (ProductRepository $repository): ProductController
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return ObjectManager
     */
    public function getEntityManager (): ObjectManager
    {
        return $this->entityManager;
    }

    /**
     * @param ObjectManager $entityManager
     */
    public function setEntityManager (ObjectManager $entityManager): ProductController
    {
        $this->entityManager = $entityManager;
        return $this;
    }
}
