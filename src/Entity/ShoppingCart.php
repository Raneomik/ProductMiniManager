<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class ShoppingCart
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var ArrayCollection
     */
    private $cartItems;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Collection|CartItem[]
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        $oldCartItem = $this->getCartItem($cartItem);
        $newSum = $oldCartItem->getQuantity() + $cartItem->getQuantity();
        if($newSum > 0){
            $cartItem->setQuantity($newSum > 0 ? $newSum : 0);
            $this->cartItems->set($cartItem->getId(), $cartItem);
        } else {
            $this->cartItems->removeElement($cartItem);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem, int $quantity = 1): self
    {
        if ($this->cartItems->contains($cartItem)) {
            if ($cartItem->getQuantity() == 1) {
                $this->cartItems->removeElement($cartItem);
            } else {
                $cartItem = $this->getCartItem($cartItem);
                $cartItem->setQuantity($cartItem->getQuantity() - $quantity);
                $this->cartItems->set($cartItem->getId(), $cartItem);
            }
        }

        return $this;
    }

    public function getCartItem(CartItem $cartItem) : CartItem
    {
        $foundCartItem = new CartItem;
        foreach ($this->cartItems->toArray() as $ci) {
            if ($ci->getId() === $cartItem->getId()) {
                $foundCartItem = $ci;
                break;
            }
        }

        return $foundCartItem;
    }

    public function getItemTotalCount() : int
    {
        $total = 0;
        foreach ($this->cartItems as $cartItem) {
            $total += $cartItem->getQuantity();
        }
        return $total;
    }


    public function getTotalPrice() : float
    {
        $total = 0;
        foreach ($this->cartItems as $cartItem) {
            $total += $cartItem->getTotalPrice();
        }
        return $total;
    }

    public function getItemPrice(CartItem $item) : float
    {
        $cartItem = $this->getCartItem($item);
        return $cartItem->getTotalPrice();
    }

    public function cleanUp()
    {
        $this->cartItems = new ArrayCollection();
    }

}
