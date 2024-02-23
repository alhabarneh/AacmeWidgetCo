<?php 
namespace App\Repositories;
use App\Repositories\Repository;
use App\Core\Database;
use App\Models\CartItem;
use PDOException;

class CartItemRepository implements Repository{
    public function __construct(private Database $database)
    {}

    public function create(CartItem $cartItem)
    {
        try {
            $prepared = $this->database->prepare(
                "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)"
            );

            $prepared->execute([
                'cart_id' => $cartItem->getCartId(),
                'product_id' => $cartItem->getProductId(),
                'quantity' => $cartItem->getQuantity()
            ]);
            
            $cartItem->setId((int) $this->database->lastInsertId());
            
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $prepared = $this->database->prepare(
                "DELETE FROM cartItems WHERE id = :id"
            );

            $prepared->execute([
                'id' => $id
            ]);
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function find(int $id)
    {
        try {
            $prepared = $this->database->prepare(
                "SELECT * FROM cartItems WHERE id = :id"
            );

            $prepared->execute([
                'id' => $id
            ]);

            return $prepared->fetch();
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function update(int $id, array $data)
    {
        try {
            $prepared = $this->database->prepare(
                "UPDATE cartItems SET cart_id = :cart_id, product_id = :product_id, quantity = :quantity WHERE id = :id"
            );

            $prepared->execute([
                'id' => $id,
                'cart_id' => $data['cart_id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity']
            ]);
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function all()
    {
        try {
            $prepared = $this->database->prepare(
                "SELECT * FROM cartItems"
            );

            $prepared->execute();

            return $prepared->fetchAll();
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }
}