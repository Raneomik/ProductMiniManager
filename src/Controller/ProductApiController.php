<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 * @Route("/api")
 */
class ProductApiController extends AbstractController
{
    /**
     * @Route("/products", name="api_product_list")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products      = $entityManager->getRepository(Product::class)->findBy([], ['name' => 'ASC']);

        return $this->json(
            [
                'products' => $products,
            ]
        );
    }

    /**
     * @Route("/product/{id}", name="api_product_details")
     */
    public function detail(Product $product) : Response
    {
        return $this->json(
            [
                'product' => $product,
            ]
        );
    }
}
