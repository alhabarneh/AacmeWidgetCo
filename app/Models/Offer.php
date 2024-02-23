<?php
use App\Models\Model;

class Offer implements Model {
    private int $id;
    private int $productId;
    private int $productQuantityForOffer;
    private float $discount;
    private string $name;

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

    public function getDiscount() : float 
    {
        return $this->discount;
    }

    public function setDiscount($discount) : Offer
    {
        $this->discount = $discount;
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