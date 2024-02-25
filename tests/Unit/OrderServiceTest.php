<?php 

namespace Tests\Unit;

use App\Models\CartItem;
use App\Models\Offer;
use App\Services\OrderService;
use App\Repositories\ProductRepository;
use App\Repositories\OfferRepository;
use App\Repositories\CartItemRepository;
use PHPUnit\Framework\TestCase;
use App\Models\Product;

class OrderServiceTest extends TestCase
{
    public function testCalculateTotalReturnsCorrectTotalWithNoDiscountApplied()
    {
        $productRepository = \Mockery::mock(ProductRepository::class);
        $product = new Product([
            'id' => 1,
            'name' => 'Product 1',
            'price' => 4000,
            'code' => 'P1'
        ]);

        $productRepository->shouldReceive('find')->with(1)->andReturn($product);

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

        $orderService->setCartId(1);
        
        $total = $orderService->calculateTotal();
        $this->assertEquals(4495, $total);
    }

    public function testCalculateTotalReturnsCorrectTotalWithDiscountApplied()
    {
        $productRepository = \Mockery::mock(ProductRepository::class);
        
        $product = new Product([
            'id' => 1,
            'name' => 'Product 1',
            'price' => 4000,
            'code' => 'P1'
        ]);

        $productRepository->shouldReceive('find')->with(1)->andReturn($product);
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

        $orderService->setCartId(1);
        
        $total = $orderService->calculateTotal();
        $this->assertEquals(6295, $total);
    }

    private function mockOfferRepository(array $mockedOffer = [])
    {
        $offerRepository = $this->createMock(OfferRepository::class);
        
        $offer = new Offer($mockedOffer);
        
        $offerRepository->method('findByProductId')->willReturn($offer);
        return $offerRepository;
    }
}