<?php
/**
 * Created by PhpStorm.
 * User: manec
 * Date: 14/11/18
 * Time: 19:36
 */

namespace App\Tests\Service;


use App\Entity\CartItem;
use App\Entity\Product;
use App\Service\SessionCartManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SessionCartManagerTest extends KernelTestCase
{
    /** @var  SessionCartManager $cartManager */
    private $cartManager;

    /** @var  ObjectManager $objectManager */
    private $objectManager;

    public function setUp()
    {
        parent::setUp();
        static::bootKernel();
        $this->cartManager   = self::$container->get(SessionCartManager::class);
        $this->objectManager = self::$container->get(ObjectManager::class);
    }

    public function testSessionCartItemAddition()
    {
        $products = $this->objectManager->getRepository(Product::class)->findAll();
        foreach ($products as $product) {
            $cartItem = new CartItem();
            $cartItem->setProduct($product);
            $cartItem->setQuantity(2);
            $this->cartManager->updateItemInCart($cartItem);
        }

        $this->assertEquals($this->cartManager->getSessionCart()->getItemTotalCount(), 24);
    }

    public function testSessionCartProductAddition()
    {
        $products = $this->objectManager->getRepository(Product::class)->findAll();
        foreach ($products as $product) {
            $this->cartManager->updateCart($product);
        }

        $this->assertEquals($this->cartManager->getSessionCart()->getItemTotalCount(), 12);
    }

    public function testSessionCartProductRemoval()
    {
        $products = $this->objectManager->getRepository(Product::class)->findAll();
        foreach ($products as $product) {
            $this->cartManager->updateCart($product);
        }
        
        foreach ($products as $product) {
            $this->cartManager->removeFromCart($product);
        }

        $this->assertEquals($this->cartManager->getSessionCart()->getItemTotalCount(), 0);
    }

}