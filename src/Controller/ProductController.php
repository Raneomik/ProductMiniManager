<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Form\AddToCartType;
use App\Service\SessionCartManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_list")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     */
    public function index() : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $products      = $entityManager->getRepository(Product::class)->findBy([], ['name' => 'ASC']);

        return $this->render(
            'product/list.html.twig',
            [
                'products' => $products,
            ]
        );
    }

    /**
     * @Route({
     *     "en": "/product/{id}",
     *     "fr": "/produit/{id}"
     * }, name="product_detail")
     * @param Product $product
     * @return Response
     */
    public function detail(Product $product) : Response
    {
        $cartItem = new CartItem;
        $cartItem->setProduct($product);
        $form = $this->createForm(AddToCartType::class, $cartItem);

        return $this->render(
            'product/detail.html.twig',
            [
                'product'       => $product,
                'AddToCartForm' => $form->createView(),
            ]
        );
    }
}
