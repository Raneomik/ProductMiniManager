<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 */
class CartItem
{
    /**
     * @ORM\GeneratedValue()
     */
    private $id;


    /**
     * @var Product $product
     */
    private $product;

    /**
     * @var int quantity
     */
    private $quantity;

    /**
     * CartItem constructor.
     */
    public function __construct()
    {
        $this->quantity = 0;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    private $shoppingCart;

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getShoppingCart(): ShoppingCart
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart(ShoppingCart $shoppingCart): self
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }
}
