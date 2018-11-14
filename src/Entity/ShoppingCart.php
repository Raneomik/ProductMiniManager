<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 */
class ShoppingCart
{
    /**
     * @ORM\GeneratedValue()
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
        if (! $this->cartItems->contains($cartItem)) {
            $cartItem->setQuantity(1);
            $cartItem->setId($cartItem->getProduct()->getId());
        } else {
            $cartItem = $this->getCartItem($cartItem);
            $cartItem->setQuantity($cartItem->getQuantity() + 1);
        }
        
        $this->cartItems->set($cartItem->getId(), $cartItem);

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItems->contains($cartItem)) {
            if ($cartItem->getQuantity() == 1) {
                $this->cartItems->removeElement($cartItem);
            } else {
                $cartItem = $this->getCartItem($cartItem);
                $cartItem->setQuantity($cartItem->getQuantity() - 1);
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

    public function cleanUp()
    {
        $this->cartItems = new ArrayCollection();
    }

}
