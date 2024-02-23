<?php

namespace App\Models;

class CartItem implements Model
{

    public function __construct(
        private int $id, 
        private int $quantity, 
        private int $cartId, 
        private int $productId
        )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setQuantity(int $quantity): CartItem
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function setCartId(int $cartId): CartItem
    {
        $this->cartId = $cartId;
        return $this;
    }

    public function setProductId(int $productId): CartItem
    {
        $this->productId = $productId;
        return $this;
    }

    public function setId(int $id): CartItem
    {
        $this->id = $id;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'cart_id' => $this->cartId,
            'product_id' => $this->productId
        ];
    }
}