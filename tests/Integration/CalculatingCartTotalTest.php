<?php
namespace Tests\Integration;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\OfferRepository;
use App\Repositories\CartRepository;
use App\Repositories\CartItemRepository;
use App\Models\CartItem;
use App\Models\Cart;
use App\Services\OrderService;

class calculateCartTotalTest extends \PHPUnit\Framework\TestCase
{
    public function testCalculateTotalReturnsCorrectTotal()
    {
        $databaseHelper = new \App\Core\Database();
        
        $productRepository = new ProductRepository($databaseHelper);
        $offerRepository = new OfferRepository($databaseHelper);
        $cartItemRepository = new CartItemRepository($databaseHelper);
        $cartRepostiry = new CartRepository($databaseHelper);

        $product1 = new Product();
        $product1->setName('Product 1');
        $product1->setPrice(4000);
        $product1->setCode('P1');

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setPrice(6000);
        $product2->setCode('P2');

        $product1 = $this->createProduct($productRepository, $product1);
        $product2 = $this->createProduct($productRepository, $product2);

        $cart = $this->createCart($cartRepostiry);
        $cartItem1 = $this->createCartItem($cartItemRepository, $cart, $product1);
        $cartItem2 = $this->createCartItem($cartItemRepository, $cart, $product2);

        $cart
            ->addCartItems([
                $cartItem1,
                $cartItem2
            ]);
        
        $orderService = new OrderService(
            $productRepository,
            $offerRepository,
            $cartItemRepository,
        );
        
        $orderService->setCartId(1);
        
        $total = $orderService->calculateTotal();
        $this->assertEquals(10000, $total);
    }

    private function createProduct(
        ProductRepository $productRepository,
        Product $product
        )
    {
        
        
        return $productRepository->create($product);
    }

    private function createCart(CartRepository $cartRepostiry)
    {
        $cart = new Cart();
        $cart->setUserId(1);
        
        return $cartRepostiry->create($cart);
    }

    private function createCartItem(CartItemRepository $cartItemRepository, Cart $cart, Product $product)
    {
        $cartItem = new CartItem(
            id: null, 
            quantity: 1, 
            cartId: $cart->getId(), 
            productId: $product->getId()
        );
        $cartItem->setQuantity(1);
        $cartItem->setCartId($cart->getId());
        $cartItem->setProductId($product->getId());
        
        return $cartItemRepository->create($cartItem);
    }
}