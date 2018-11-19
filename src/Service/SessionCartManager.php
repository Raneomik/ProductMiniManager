<?php

namespace App\Service;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionCartManager
{

    static private $sessionCartVarName = 'shopping_cart';

    /**
     * @var SessionInterface $session
     */
    private $session;

    /**
     * SessionCartManager constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $sessionCart = new ShoppingCart;
        
        if($this->session->has(self::$sessionCartVarName)){
            $sessionCart = $this->getSessionCart();
        }
        
        $this->updateSessionCart($sessionCart);
    }

    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function addToCart(Product $product, int $quantity = 1): void
    {
        $cartItem = $this->getCartItemForProduct($product);
        $cartItem->setQuantity($quantity);
        $cart = $this->getSessionCart()->addCartItem($cartItem);
        $this->updateSessionCart($cart);
    }

    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function removeFromCart(Product $product, int $quantity = 1): void
    {
        $cartItem = $this->getCartItemForProduct($product);
        $cart = $this->getSessionCart()->removeCartItem($cartItem, $quantity);
        $this->updateSessionCart($cart);
    }

    /**
     * @param CartItem $item
     */
    public function addItemToCart(CartItem $item): void
    {
        $cart = $this->getSessionCart()->addCartItem($item);
        $this->updateSessionCart($cart);
    }

    /**
     * @param CartItem $item
     */
    public function updateItemInCart(CartItem $item): void
    {
        $cart = $this->getSessionCart()->updateCartItem($item);
        $this->updateSessionCart($cart);
    }


    /**
     * @param CartItem $item
     */
    public function removeItemFromCart(CartItem $item): void
    {
        $cart = $this->getSessionCart()->removeCartItem($item);
        $this->updateSessionCart($cart);
    }

    /**
     * @return void
     */
    public function cleanUpCart() : void
    {
        $cart = $this->getSessionCart()->cleanUp();
        $this->updateSessionCart($cart);
    }

    /**
     * @return float
     */
    public function getCartTotalPrice() : float
    {
        return $this->getSessionCart()->getTotalPrice();
    }

    /**
     * @return ShoppingCart
     */
    public function getSessionCart() : ShoppingCart
    {
        return $this->session->get(self::$sessionCartVarName);
    }

    /**
     * @param ShoppingCart $sessionCart
     */
    private function updateSessionCart(ShoppingCart $sessionCart) : void
    {
        $this->session->set(self::$sessionCartVarName, $sessionCart);
    }

    /**
     * @param Product $product
     * @return CartItem
     */
    private function getCartItemForProduct(Product $product) : CartItem
    {
        $foundCartItem = new CartItem;
        $foundCartItem->setProduct($product);
        $foundCartItem->setQuantity(1);
        
        foreach ($this->getSessionCart()->getCartItems() as $cartItem){
            if($cartItem->getId() === $product->getId()){
                $foundCartItem = $cartItem;
                break;
            }
        }

        return $foundCartItem;
    }

}