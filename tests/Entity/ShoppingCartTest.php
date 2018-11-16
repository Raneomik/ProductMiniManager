<?php

namespace App\Tests\Entity;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use Nubs\RandomNameGenerator\Vgng as NameGenerator;
use PHPUnit\Framework\TestCase;
use RandomLib\Factory as RandomFactory;

class ShoppingCartTest extends TestCase
{
    /**
     * @var ShoppingCart $shoppingCart
     */
    private $shoppingCart;

    public function setUp()
    {
        $this->shoppingCart = new ShoppingCart;
    }

    /**
     * @test
     */
    public function add3SameItemsToCartTest()
    {
        $this->shoppingCart->cleanUp();

        $cartItem = $this->createCartItem();
        $cartItem->setQuantity(3);
        $this->shoppingCart->updateCartItem($cartItem);

        $this->assertEquals($cartItem->getQuantity(), 3);
    }

    /**
     * @test
     */
    public function ItemAddToAndRemoveFromCartTest()
    {
        $this->shoppingCart->cleanUp();

        $cartItem = $this->createCartItem();
        $this->shoppingCart->updateCartItem($cartItem);
        $this->shoppingCart->removeCartItem($cartItem);

        $this->assertEquals($this->shoppingCart->getItemTotalCount(), 0);
    }

    /**
     * @test
     */
    public function addSeveralDifferentItemsToCart()
    {
        $this->shoppingCart->cleanUp();
        $cartItem1 = $this->createCartItem();

        $cartItem1->setQuantity(2);
        $this->shoppingCart->updateCartItem($cartItem1);

        $cartItem2 = $this->createCartItem();

        $cartItem2->setQuantity(3);
        $this->shoppingCart->updateCartItem($cartItem2);

        $cartItem3 = $this->createCartItem();

        $this->shoppingCart->updateCartItem($cartItem3);
//
//        $this->assertEquals($cartItem1->getQuantity(), 3);
        $this->assertEquals($cartItem3->getQuantity(), 1);
    }

    /**
     * @test
     */
    public function testTotalCartCount()
    {
        $this->shoppingCart->cleanUp();

        $cartItem1 = $this->createCartItem();

        $this->shoppingCart->updateCartItem($cartItem1);

        $cartItem2 = $this->createCartItem();

        $cartItem2->setQuantity(5);
        $this->shoppingCart->updateCartItem($cartItem2);

        $cartItem3 = $this->createCartItem();

        $this->shoppingCart->updateCartItem($cartItem3);

        $this->shoppingCart->removeCartItem($cartItem2);

        $this->assertEquals($this->shoppingCart->getItemTotalCount(), 6);

    }

    /**
     * @return CartItem
     */
    private function createCartItem() : CartItem
    {
        $randomFactory = new RandomFactory;
        $generator     = new NameGenerator;
        $gen           = $randomFactory->getMediumStrengthGenerator();

        $product = new Product();
        $product->setName($generator->getName());
        $product->setId($this->shoppingCart->getItemTotalCount());
        $product->setPrice($gen->generateInt(1, 20));

        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);

        return $cartItem;
    }

}
