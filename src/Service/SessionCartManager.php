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
     * @var SessionInterface $session
     */
    private $session;

    /**
     * @var ShoppingCart $sessionCart
     */
    private $sessionCart;

    /**
     * SessionCartManager constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->updateSessionCart();
    }


    public function updateCart(Product $product, int $quantity = 1)
    {
        $cartItem = $this->getCartItemForProduct($product);
        $this->sessionCart->updateCartItem($cartItem, $quantity);
        $this->updateSessionCart();
    }

    public function removeFromCart(Product $product, int $quantity = 1)
    {
        $cartItem = $this->getCartItemForProduct($product);
        $this->sessionCart->removeCartItem($cartItem, $quantity);
        $this->updateSessionCart();
    }

    public function updateItemInCart(CartItem $item)
    {
        $this->sessionCart->updateCartItem($item);
        $this->updateSessionCart();
    }

    public function removeItemFromCart(CartItem $item)
    {
        $this->sessionCart->removeCartItem($item);
        $this->updateSessionCart();
    }

    public function cleanUpCart()
    {
        $this->sessionCart->cleanUp();
        $this->updateSessionCart();
    }


    public function getCartTotalPrice()
    {
        return $this->getSessionCart()->getTotalPrice();
    }

    public function getSessionCart() : ShoppingCart
    {
        return $this->session->get(self::SHOPPING_CART_SESSION_VARNAME);
    }

    private function updateSessionCart()
    {
        if ($this->session->has(self::SHOPPING_CART_SESSION_VARNAME)) {
            $this->sessionCart = $this->session->get(self::SHOPPING_CART_SESSION_VARNAME);
        } else {
            $this->sessionCart = new ShoppingCart;
            $this->session->set(self::SHOPPING_CART_SESSION_VARNAME, $this->sessionCart);
        }
    }
    
    private function getCartItemForProduct(Product $product) : CartItem
    {
        $foundCartItem = new CartItem;
        $foundCartItem->setProduct($product);
        $foundCartItem->setQuantity(1);
        
        foreach ($this->sessionCart->getCartItems() as $cartItem){
            if($cartItem->getId() === $product->getId()){
                $foundCartItem = $cartItem;
                break;
            }
        }

        return $foundCartItem;
    }

    /**
     * @param SessionInterface $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }

}