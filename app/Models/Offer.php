<?php
namespace App\Models;
use App\Models\Model;

class Offer implements Model {
    private int $id;
    private int $productId;
    private int $productQuantityForOffer;
    private float $discountRate;
    private string $name;

    public function __construct(array $data = []) {
        $this->id = $data['id'] ?? 0;
        $this->productId = $data['product_id'] ?? 0;
        $this->productQuantityForOffer = $data['product_quantity_for_offer'] ?? 0;
        $this->discountRate = $data['discount_rate'] ?? 0;
        $this->name = $data['name'] ?? '';
    }
    
    public function getId() : int {
        return $this->id;
    }

    public function setId(int $id) : Offer {
        $this->id = $id;
        return $this;
    }

    public function getProductId() : int 
    {
        return $this->productId;
    }

    public function setProductId(int $productId) : Offer 
    {
        $this->productId = $productId;
        return $this;
    }

    public function getProductQuantityForOffer() : int 
    {
        return $this->productQuantityForOffer;
    }

    public function setProductQuantityForOffer(int $productQuantityForOffer) : Offer 
    {
        $this->productQuantityForOffer = $productQuantityForOffer;
        return $this;
    }

    public function getDiscountRate() : float 
    {
        return $this->discountRate;
    }

    public function setDiscountRate(float $discountRate) : Offer
    {
        $this->discountRate = $discountRate;
        return $this;
    }

    public function getName() : string 
    {
        return $this->name;
    }

    public function setName(string $name) : Offer 
    {
        $this->name = $name;
        return $this;
    }
}