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

    public function setUp() : void
    {
        $this->shoppingCart = new ShoppingCart;
    }

    /**
     * @test
     */
    public function test3SameItemsToCartAddition() : void
    {
        $this->shoppingCart->cleanUp();

        $cartItem = $this->createCartItem();
        $cartItem->setQuantity(3);
        $this->shoppingCart->addCartItem($cartItem);

        $this->assertEquals($cartItem->getQuantity(), 3);
    }

    /**
     * @test
     */
    public function testItemToAndFromCartAdditionAndRemoval() : void
    {
        $this->shoppingCart->cleanUp();

        $cartItem = $this->createCartItem();
        $this->shoppingCart->addCartItem($cartItem);
        $this->shoppingCart->removeCartItem($cartItem);

        $this->assertEquals($this->shoppingCart->getItemTotalCount(), 0);
    }

    /**
     * @test
     */
    public function testSeveralDifferentItemsToCartAddition() : void
    {
        $this->shoppingCart->cleanUp();

        $cartItem1 = $this->createCartItem();
        $cartItem1->setQuantity(2);
        $this->shoppingCart->addCartItem($cartItem1); // +2

        $cartItem2 = $this->createCartItem();
        $cartItem2->setQuantity(3);
        $this->shoppingCart->addCartItem($cartItem2); // +3

        $cartItem3 = $this->createCartItem();
        $this->shoppingCart->addCartItem($cartItem3); // +1

        $this->assertEquals($this->shoppingCart->getItemTotalCount(), 6);
    }

    /**
     * @test
     */
    public function testTotalCartCount() : void
    {
        $this->shoppingCart->cleanUp();

        $cartItem1 = $this->createCartItem();
        $this->shoppingCart->addCartItem($cartItem1); // +1

        $cartItem2 = $this->createCartItem();
        $cartItem2->setQuantity(5);
        $this->shoppingCart->addCartItem($cartItem2); // +5

        $cartItem3 = $this->createCartItem();
        $this->shoppingCart->addCartItem($cartItem3); // +1

        $this->shoppingCart->removeCartItem($cartItem2); // -1

        $this->assertEquals($this->shoppingCart->getItemTotalCount(), 6);
    }

    /**
     * @test
     */
    public function testTotalCartPrice() : void
    {
        $this->shoppingCart->cleanUp();

        $totalExpected = 0;

        $cartItem1 = $this->createCartItem();
        $this->shoppingCart->addCartItem($cartItem1);
        $totalExpected += $cartItem1->getProduct()->getPrice();

        $cartItem2 = $this->createCartItem();
        $cartItem2->setQuantity(5);
        $this->shoppingCart->addCartItem($cartItem2);
        $totalExpected += 5 * $cartItem2->getProduct()->getPrice();

        $cartItem3 = $this->createCartItem();
        $this->shoppingCart->addCartItem($cartItem3);
        $totalExpected += $cartItem3->getProduct()->getPrice();

        $this->shoppingCart->removeCartItem($cartItem2);
        $totalExpected -= $cartItem2->getProduct()->getPrice();

        $this->assertEquals($this->shoppingCart->getTotalPrice(), $totalExpected);
    }

    /**
     * @return CartItem
     */
    private function createCartItem() : CartItem
    {
        $generator = new NameGenerator;

        $product = new Product();
        $product->setName($generator->getName());
        $product->setId($this->shoppingCart->getItemTotalCount());
        $product->setPrice($this->randomFloat(1, 20));

        $cartItem = new CartItem();
        $cartItem->setProduct($product);
        $cartItem->setQuantity(1);

        return $cartItem;
    }

    private function randomFloat($st_num = 0, $end_num = 1) : float
    {
        return number_format((float)rand($st_num, $end_num), 2);
    }
}
