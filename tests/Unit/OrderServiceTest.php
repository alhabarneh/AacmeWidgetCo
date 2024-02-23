<?php 

namespace Tests\Unit;

use App\Models\CartItem;
use App\Services\OrderService;
use App\Repositories\ProductRepository;
use App\Repositories\OfferRepository;
use App\Repositories\CartItemRepository;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    public function testCalculateTotalReturnsCorrectTotalWithNoDiscountApplied()
    {
        $productRepository = $this->mockProductRepository([
            'id' => 1,
            'name' => 'Product 1',
            'price' => 4000,
            'code' => 'P1'
        ]);
        $offerRepository = $this->mockOfferRepository();

        $cartItemRepository = $this->createMock(CartItemRepository::class);
        $cartItemRepository->method('findByCartId')->willReturn([
            new CartItem(id: 1, quantity: 1, cartId: 1, productId: 1),
        ]);

        $orderService = new OrderService(
            $productRepository,
            $offerRepository,
            $cartItemRepository,
        );
        
        $total = $orderService->calculateTotal();
        $this->assertEquals(4495, $total);
    }

    public function testCalculateTotalReturnsCorrectTotalWithDiscountApplied()
    {
        $productRepository = $this->mockProductRepository([
            'id' => 1,
            'name' => 'Product 1',
            'price' => 4000,
            'code' => 'P1'
        ]);
        $offerRepository = $this->mockOfferRepository([
            'id' => 1,
            'product_id' => 1,
            'product_quantity_for_offer' => 2,
            'discount_rate' => 0.5
        ]);

        $cartItemRepository = $this->createMock(CartItemRepository::class);
        $cartItemRepository->method('findByCartId')->willReturn([
            new CartItem(id: 1, quantity: 2, cartId: 1, productId: 1),
        ]);

        $orderService = new OrderService(
            $productRepository,
            $offerRepository,
            $cartItemRepository,
        );
        
        $total = $orderService->calculateTotal();
        $this->assertEquals(6295, $total);
    }

    private function mockProductRepository(array $mockedProduct = [])
    {
        $productRepository = $this->createMock(ProductRepository::class);
        $productRepository->method('find')->willReturn($mockedProduct);
        return $productRepository;
    }

    private function mockOfferRepository(array $mockedOffer = [])
    {
        $offerRepository = $this->createMock(OfferRepository::class);
        $offerRepository->method('findByProductId')->willReturn($mockedOffer);
        return $offerRepository;
    }

    // private function mockCartItemRepository()
    // {
    //     $cartItemRepository = $this->createMock(CartItemRepository::class);
    //     $cartItemRepository->method('getCartItem')->willReturn('Cart Item 1');
    //     return $cartItemRepository;
    // }
}