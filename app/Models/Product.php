<?php
namespace App\Models;

class Product implements Model
{

    private int $id;
    private string $name;
    private int $price;
    private string $code;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->price = $data['price'] ?? 0;
        $this->code = $data['code'] ?? '';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }   
}