<?php

namespace App\Tests\Entity;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use Nubs\RandomNameGenerator\Vgng as NameGenerator;
use RandomLib\Factory as RandomFactory;

class ShoppingCartTest extends \PHPUnit_Framework_TestCase
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
        $cartItem = $this->createCartItem();

        $this->shoppingCart->addCartItem($cartItem);
        $this->shoppingCart->addCartItem($cartItem);
        $this->shoppingCart->addCartItem($cartItem);

        $this->assertTrue($this->shoppingCart->getCartItem($cartItem)->getQuantity() == 3);
    }

    /**
     * @test
     */
    public function ItemAddToAndRemoveFromCartTest()
    {
        $cartItem = $this->createCartItem();
        $this->shoppingCart->addCartItem($cartItem);
        $this->shoppingCart->removeCartItem($cartItem);

        $this->assertTrue($this->shoppingCart->getItemTotalCount() == 0);
        $this->assertTrue($this->shoppingCart->getCartItem($cartItem)->getQuantity() == 0);
    }

    /**
     * @test
     */
    public function addSeveralDifferentItemsToCart()
    {
        $cartItem1 = $this->createCartItem();

        $this->shoppingCart->addCartItem($cartItem1);
        $this->shoppingCart->addCartItem($cartItem1);
        $this->shoppingCart->addCartItem($cartItem1);

        $cartItem2 = $this->createCartItem();

        $this->shoppingCart->addCartItem($cartItem2);
        $this->shoppingCart->addCartItem($cartItem2);

        $cartItem3 = $this->createCartItem();

        $this->shoppingCart->addCartItem($cartItem3);

        $this->assertTrue($this->shoppingCart->getCartItem($cartItem1)->getQuantity() == 3);
        $this->assertTrue($this->shoppingCart->getCartItem($cartItem2)->getQuantity() == 2);
        $this->assertTrue($this->shoppingCart->getCartItem($cartItem3)->getQuantity() == 1);
    }

    /**
     * @test
     */
    public function testTotalCartCount()
    {
        $cartItem1 = $this->createCartItem();

        $this->shoppingCart->addCartItem($cartItem1);
        $this->shoppingCart->addCartItem($cartItem1);
        $this->shoppingCart->addCartItem($cartItem1);

        $cartItem2 = $this->createCartItem();

        $this->shoppingCart->addCartItem($cartItem2);
        $this->shoppingCart->addCartItem($cartItem2);

        $cartItem3 = $this->createCartItem();

        $this->shoppingCart->addCartItem($cartItem3);

        $this->shoppingCart->removeCartItem($cartItem2);

        $this->assertTrue($this->shoppingCart->getItemTotalCount() == 5);

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
        $product->setPrice($gen->generateInt(1, 1000));

        $cartItem = new CartItem();
        $cartItem->setId($gen->generateInt(1, 1000));
        $cartItem->setProduct($product);

        return $cartItem;
    }

}
