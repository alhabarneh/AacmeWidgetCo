<?php
namespace App\Models;

class Cart implements Model
{
    private int $id;
    private int $userId;
    private array $cartItems = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setCartItem(CartItem $cartItem): void
    {
        $this->cartItems[] = $cartItem;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getCartItems(): array
    {
        return $this->cartItems;
    }

    public function getSubTotal(): int
    {
        $subTotal = 0;
        foreach ($this->cartItems as $cartItem) {
            $subTotal += $cartItem->getProduct()->getPrice() * $cartItem->getQuantity();
        }
        return $subTotal;
    }
}