<?php 
namespace App\Repositories;
use App\Repositories\Repository;
use App\Core\Database;
use App\Models\Product;
use PDOException;

class ProductRepository implements Repository{
    public function __construct(private Database $database)
    {}

    public function create(Product $product)
    {
        try {
            $prepared = $this->database->prepare(
                "INSERT INTO products (name, price, code) VALUES (:name, :price, :code)"
            );

            $prepared->execute([
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'code' => $product->getCode()
            ]);
            
            $product->setId((int) $this->database->lastInsertId());
            
            return $product;
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function delete(int $id)
    {
        try {
            $prepared = $this->database->prepare(
                "DELETE FROM products WHERE id = :id"
            );

            $prepared->execute([
                'id' => $id
            ]);
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function findByCode(string $code)
    {
        try {
            $prepared = $this->database->prepare(
                "SELECT * FROM products WHERE code = :code"
            );

            $prepared->execute([
                'code' => $code
            ]);

            return $prepared->fetch();
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function find(int $id)
    {
        try {
            $prepared = $this->database->prepare(
                "SELECT * FROM products WHERE id = :id"
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
                "UPDATE products SET name = :name, price = :price, code = :code WHERE id = :id"
            );

            $prepared->execute([
                'id' => $id,
                'name' => $data['name'],
                'price' => $data['price'],
                'code' => $data['code']
            ]);
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

    public function all()
    {
        try {
            $prepared = $this->database->prepare(
                "SELECT * FROM products"
            );

            $prepared->execute();

            return $prepared->fetchAll();
        } catch (PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }
}