<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\SessionCartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShoppingCartController
 * @package App\Controller
 * @Route("/shopping-cart")
 */
class ShoppingCartController extends AbstractController
{
    /**
     * @Route("/", name="shopping_cart")
     */
    public function index(SessionCartManager $cartMan) : Response
    {
        $shoppingCart = $cartMan->getSessionCart();
        $products = $shoppingCart->getCartItems();


        return $this->render('shopping_cart/index.html.twig', [
            'product_items' => $products,
        ]);
    }
    
    /**
     * @Route("/add-product/{id}", name="shopping_cart_add")
     */
    public function addProduct(SessionCartManager $cartMan, Product $product) : Response
    {
        $cartMan->addToCart($product);
        
        return $this->redirectToRoute('shopping_cart');
    }

    /**
     * @Route("/remove-product/{id}", name="shopping_cart_remove")
     */
    public function removeProduct(SessionCartManager $cartMan, Product $product) : Response
    {
        $cartMan->removeFromCart($product);

        return $this->redirectToRoute('shopping_cart');
    }
    
    /**
     * @Route("/clean-cart", name="shopping_cart_clean")
     */
    public function clean(SessionCartManager $cartMan) : Response
    {
        $cartMan->cleanUpCart();

        return $this->redirectToRoute('product_list');

    }
}
