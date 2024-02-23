<?php 
namespace App\Repositories;
use App\Repositories\Repository;
use App\Core\Database;
use App\Models\Cart;
use PDOException;

class CartRepository implements Repository{
    public function __construct(private Database $database)
    {}

    public function create(Cart &$cart)
    {
        try {
            $prepared = $this->database->prepare(
                "INSERT INTO carts (user_id) VALUES (:user_id)"
            );

            $prepared->execute([
                'user_id' => $cart->getUserId(),
            ]);
            
            $cart->setId((int) $this->database->lastInsertId());

            return $cart;
            
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $prepared = $this->database->prepare(
                "DELETE FROM carts WHERE id = :id"
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
                "SELECT * FROM carts WHERE id = :id"
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
                "UPDATE carts SET user_id = :user_id WHERE id = :id"
            );

            $prepared->execute([
                'id' => $id,
                'user_id' => $data['userId'],
            ]);
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function all()
    {
        try {
            $prepared = $this->database->prepare(
                "SELECT * FROM carts"
            );

            $prepared->execute();

            return $prepared->fetchAll();
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }
}