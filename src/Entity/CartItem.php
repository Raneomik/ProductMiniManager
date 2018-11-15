<?php

namespace App\Entity;

class CartItem
{
    /**
     * @var int id
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
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     *
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Product
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return CartItem
     */
    public function setProduct(Product $product): self
    {
        $this->id = $product->getId();
        $this->product = $product;

        return $this;
    }

    public function getTotalPrice() : float
    {
        return $this->product->getPrice() * $this->quantity;
    }

}
