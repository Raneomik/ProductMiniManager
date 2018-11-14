<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionCartManager
{

    const SHOPPING_CART_SESSION_VARNAME = 'shopping_cart';

    /**
     * @var Session $session
     */
    private $session;

    /**
     * SessionCartManager constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    public function addToCart(Product $product)
    {
        $sessionCart = $this->getSessionCart();
        $cartItem = $this->getCartItemForProduct($product);
        $sessionCart->addCartItem($cartItem);
        $this->updateSessionCart($sessionCart);
    }

    public function removeFromCart(Product $product)
    {
        $sessionCart = $this->getSessionCart();
        $cartItem = $this->getCartItemForProduct($product);
        $sessionCart->removeCartItem($cartItem);
        $this->updateSessionCart($sessionCart);
    }

    public function cleanUpCart()
    {
        $sessionCart = $this->getSessionCart();
        $sessionCart->cleanUp();
        $this->updateSessionCart($sessionCart);
    }

    public function getSessionCart() : ShoppingCart
    {
        $sessionCart = new ShoppingCart;
        if ($this->session->has(self::SHOPPING_CART_SESSION_VARNAME)) {
            $sessionCart = $this->session->get(self::SHOPPING_CART_SESSION_VARNAME);
        } else {
            $this->session->set(self::SHOPPING_CART_SESSION_VARNAME, $sessionCart);
        }

        return $sessionCart;
    }

    private function updateSessionCart(ShoppingCart $sessionCart)
    {
        if ($this->session->has(self::SHOPPING_CART_SESSION_VARNAME)) {
            $this->session->set(self::SHOPPING_CART_SESSION_VARNAME, $sessionCart);
        }
    }
    
    private function getCartItemForProduct(Product $product) : CartItem
    {
        $sessionCart = $this->getSessionCart();

        $foundCartItem = new CartItem;
        $foundCartItem->setProduct($product);
        foreach ($sessionCart->getCartItems() as $cartItem){
            if($cartItem->getProduct() === $product){
                $foundCartItem = $cartItem;
                break;
            }
        }

        return $foundCartItem;
    }
}