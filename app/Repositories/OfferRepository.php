<?php

namespace App\Repositories;

use App\Core\Database;
use App\Repositories\Repository;
use App\Models\Offer;
use PDO;

class OfferRepository implements Repository {
    public function __construct(private Database $database) 
    {}
        
    public function all()
    {
        try {
            $prepared = $this->database->prepare("SELECT * FROM offers");
            $prepared->execute();
            return $prepared->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }            
    }
    
    public function create(Offer $offer)
    {
        try {
            $prepared = $this->database->prepare("INSERT INTO offers (product_id, product_quantity_for_offer, discount, name) VALUES (:product_id, :product_quantity_for_offer, :discount, :name)");
            $prepared->execute([
                "product_id"=> $offer->getProductId(),
                "product_quantity_for_offer"=> $offer->getProductQuantityForOffer(),
                "discount"=> $offer->getDiscountRate(),
                "name"=> $offer->getName(),
            ]);

            $offer->setId((int) $this->database->lastInsertId());

            return $offer;
        } catch (\PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }
    
    public function delete($id)
    {
        try {
            $prepared = $this->database->prepare("DELETE FROM offers WHERE id = :id");
            $prepared->execute([
                "id"=> $id
            ]);
        } catch (\PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }
    
    public function find($id)
    {
        try {
            $prepared = $this->database->prepare("SELECT * FROM offers WHERE id = :id");
            $prepared->execute([
                "id"=> $id
            ]);
            
            return $prepared->fetch();
        } catch (\PDOException $e) {
            throw new \RepositoryException("Not Found", 404);
        }
    }

    public function findByProductId($productId)
    {
        try {
            $prepared = $this->database->prepare("SELECT * FROM offers WHERE product_id = :product_id");
            $prepared->execute([
                "product_id"=> $productId
            ]);
            
            return $prepared->fetch();
        } catch (\PDOException $e) {
            throw new \RepositoryException("Not Found", 404);
        }
    }

    public function findByProductIds(array $productIds)
    {
        try {
            $in = implode(',', $productIds);
            $prepared = $this->database->prepare("SELECT * FROM offers WHERE product_id IN ($in)");
            $prepared->execute($productIds);
            $offers = $prepared->fetchAll(PDO::FETCH_ASSOC);
            return $offers;
        } catch (\PDOException $e) {
            throw new \RepositoryException("Not Found", 404);
        }
    }
    
    public function update($id, array $data)
    {
        try {
            $prepared = $this->database->prepare("UPDATE offers SET product_id = :product_id, product_quantity_for_offer = :product_quantity_for_offer, discount = :discount, name = :name WHERE id = :id");
            $prepared->execute([
                "product_id"=> $data['product_id'],
                "product_quantity_for_offer"=> $data['product_quantity_for_offer'],
                "discount"=> $data['discount'],
                "name"=> $data['name'],
                "id"=> $id
            ]);
        } catch (\PDOException $e) {
            throw new \RepositoryException($e->getMessage(), 500);
        }
    }

}