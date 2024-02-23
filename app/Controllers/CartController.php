<?php 
namespace App\Controllers;
use App\Repositories\CartItemRepository;
use App\Repositories\CartRepository;
use ControllerException;
use OfferRepository;
use RepositoryException;
use App\Models\Cart;
class CartController {
    public function __construct(
        private CartRepository $cartRepository,
        private CartItemRepository $cartItemRepository,
    ){}

    public function add(int $userId) {
        try {
            $cart = new Cart();
            $cart->setUserId($userId);
            $this->cartRepository->create($cart);
            
            return (array) $cart;
        } catch (RepositoryException $e) {
            throw new ControllerException($e->getMessage(), 401, $e);
        }
    }

    public function delete(int $cartId) {
        try {
            $this->cartRepository->delete($cartId);
        } catch (RepositoryException $e) {
            throw new ControllerException("Unable to delete cart", 401, $e);
        }
    }

    public function get(int $cartId) {
        try {
            $cart = $this->cartRepository->find($cartId);
            return (array) $cart;
        } catch (RepositoryException $e) {
            throw new ControllerException("Unable to find cart", 404, $e);
        }
    }

    public function getCartWithItems(int $cartId) {
        try {
            $cart = $this->cartRepository->find($cartId);
            $cartItems = $this->cartItemRepository->findByCartId($cartId);
            $cart->setCartItems($cartItems);
            
            return (array) $cart;
        } catch (RepositoryException $e) {
            throw new ControllerException("Unable to find cart", 404, $e);
        }
    }

    public function update(int $cartId, array $data) {
        try {
            $this->cartRepository->update($cartId, $data);
            
        } catch (RepositoryException $e) {
            throw new ControllerException("Unable to update cart",404, $e);
        }
    }
}