<?php

namespace App\Services;
use App\Models\CartItem;
use App\Repositories\CartItemRepository;
use App\Repositories\ProductRepository;
use App\Repositories\OfferRepository;
use App\Models\Product;

class OrderService
{
    private int $cartId;
    public function __construct(
        private ProductRepository $productRepository,
        private OfferRepository $offerRepository,
        private CartItemRepository $cartItemRepository
    ) {}

    public function setCartId(int $cartId): void
    {
        $this->cartId = $cartId;
    }

    public function calculateTotal(): int
    {
        $cartItems = $this->cartItemRepository->findByCartId($this->cartId);
        
        $total = 0;
        foreach ($cartItems as $cartItem) {
            $product = $this->productRepository->find($cartItem->getProductId());
            // $offers = $this->offerRepository->findByProductId($product->getId());
            $total += ($product->getPrice() * $cartItem->getQuantity()) - $this->applyOffers($cartItem, $product);
        }

        $shippingCost = $this->calculateShippingCost($total);

        return $total + $shippingCost;
    }

    private function applyOffers(CartItem $cartItem, Product $product): int
    {
        if (! $offer = $this->offerRepository->findByProductId($product->getId())) {
            return 0;
        }
        
        if ($cartItem->getQuantity() < $offer->getProductQuantityForOffer() || $offer->getProductQuantityForOffer() === 0){
            return 0;
        }
        
        $productMod = $cartItem->getQuantity() % $offer->getProductQuantityForOffer();
        $discountedProductQuantity = $cartItem->getQuantity() - $productMod;
        $discountedCount = $discountedProductQuantity / $offer->getProductQuantityForOffer();

        return $product->getPrice() * $discountedCount * $offer->getDiscountRate();
    }

    private function calculateShippingCost(int $total): int
    {
        $totalInDollars = (float) $total / 100; // convert to dollars to make it more readable
        
        $shippingCost = 0;
        if ($totalInDollars < 50) {
            $shippingCost = 4.95;
        } elseif ($totalInDollars >= 50 && $totalInDollars < 90) {
            $shippingCost = 2.95;
        }

        return (int) ($shippingCost * 100); // convert back to cents
    }
}