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

    public function addCartItem(CartItem $cartItem): void
    {
        $this->cartItems[] = $cartItem;
    }

    public function addCartItems(array $cartItems): void
    {
        $this->cartItems = array_merge($this->cartItems, $cartItems);
    }

    public function removeCartItem(CartItem $cartItem): void
    {
        $this->cartItems = array_filter($this->cartItems, fn($item) => $item->getId() !== $cartItem->getId());
    }

    public function getCartItem(int $id): CartItem
    {
        return array_filter($this->cartItems, fn($item) => $item->getId() === $id)[0];
    }

    public function clearCartItems(): void
    {
        $this->cartItems = [];
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
            var_dump($cartItem);

            $subTotal += $cartItem->getProduct()['price'] * $cartItem->getQuantity();
        }
        return $subTotal;
    }
}