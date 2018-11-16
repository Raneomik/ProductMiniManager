<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Form\AddToCartType;
use App\Service\SessionCartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShoppingCartController
 * @package App\Controller
 * @Route({
 *     "en": "/shopping-cart",
 *     "fr": "/panier"
 * })
 */
class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/", name="shopping_cart")
     * @param SessionCartManager $cartManager
     * @return Response
     */
    public function index(SessionCartManager $cartManager) : Response
    {
        $shoppingCart = $cartManager->getSessionCart();
        $products     = $shoppingCart->getCartItems();

        return $this->render(
            'shopping_cart/index.html.twig',
            [
                'product_items' => $products,
            ]
        );
    }

    /**
     * @Route("/add-product", name="shopping_cart_add")
     * @param SessionCartManager $cartManager
     * @param Request $request
     * @return Response
     */
    public function addProduct(SessionCartManager $cartManager, Request $request) : Response
    {
        $form = $this->createForm(AddToCartType::class, new CartItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cartItem = $form->getData();
            $cartManager->updateItemInCart($cartItem);

            return $this->redirectToRoute('shopping_cart');
        }

        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/remove-product/{id}", name="shopping_cart_remove")
     * @param SessionCartManager $cartManager
     * @param Product $product
     * @return Response
     */
    public function removeProduct(SessionCartManager $cartManager, Product $product) : Response
    {
        $cartManager->removeFromCart($product);

        if ($cartManager->getSessionCart()->getItemTotalCount() > 0) {
            return $this->redirectToRoute('shopping_cart');
        }

        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/clean-cart", name="shopping_cart_clean")
     * @param SessionCartManager $cartManager
     * @return Response
     */
    public function clean(SessionCartManager $cartManager) : Response
    {
        $cartManager->cleanUpCart();

        return $this->redirectToRoute('product_list');
    }
}
