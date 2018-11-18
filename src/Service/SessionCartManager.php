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
        $this->sessionCart = new ShoppingCart;
        $this->updateSessionCart();
    }

    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function addToCart(Product $product, int $quantity = 1): void
    {
        $cartItem = $this->getCartItemForProduct($product);
        $cartItem->setQuantity($quantity);
        $this->sessionCart->addCartItem($cartItem);
        $this->updateSessionCart();
    }

    /**
     * @param Product $product
     * @param int     $quantity
     */
    public function removeFromCart(Product $product, int $quantity = 1): void
    {
        $cartItem = $this->getCartItemForProduct($product);
        $this->sessionCart->removeCartItem($cartItem, $quantity);
        $this->updateSessionCart();
    }

    /**
     * @param CartItem $item
     */
    public function addItemToCart(CartItem $item): void
    {
        $this->sessionCart = $this->sessionCart->addCartItem($item);
        $this->updateSessionCart();
    }

    /**
     * @param CartItem $item
     */
    public function updateItemInCart(CartItem $item): void
    {
        $this->sessionCart->updateCartItem($item);
        $this->updateSessionCart();
    }


    /**
     * @param CartItem $item
     */
    public function removeItemFromCart(CartItem $item): void
    {
        $this->sessionCart->removeCartItem($item);
        $this->updateSessionCart();
    }

    /**
     * @return void
     */
    public function cleanUpCart() : void
    {
        $this->sessionCart->cleanUp();
        $this->updateSessionCart();
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
        return $this->session->get(self::SHOPPING_CART_SESSION_VARNAME);
    }

    /**
     * @return void
     */
    private function updateSessionCart() : void
    {
        if (! $this->session->has(self::SHOPPING_CART_SESSION_VARNAME)) {
            $this->sessionCart = new ShoppingCart;
        }
        $this->session->set(self::SHOPPING_CART_SESSION_VARNAME, $this->sessionCart);

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
        
        foreach ($this->sessionCart->getCartItems() as $cartItem){
            if($cartItem->getId() === $product->getId()){
                $foundCartItem = $cartItem;
                break;
            }
        }

        return $foundCartItem;
    }

}