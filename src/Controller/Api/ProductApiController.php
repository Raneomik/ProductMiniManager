<?php

namespace App\Controller\Api;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductApiController extends AbstractController
{
    /**
     * @Route("/products", name="api_product_list")
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index(SerializerInterface $serializer)  : JsonResponse
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
     * @param SerializerInterface $serializer
     * @param Product $product
     * @return JsonResponse
     */
    public function detail(SerializerInterface $serializer, Product $product) : JsonResponse
    {
        return $this->json(
            [
                'product' => $product,
            ]
        );
    }
}
