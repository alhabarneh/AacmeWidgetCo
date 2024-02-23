<?php 
use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductController {
    public function __construct(
        private ProductRepository $productRepository,
        ) {}

    public function add(string $name, int $price, string $code)
    {
        try {
            $product = new Product();
            $product->setName(trim($name));
            $product->setPrice($price);
            $product->setCode($code);
            $this->productRepository->create($product);
            
        } catch (RepositoryException $e) {
            throw new ControllerException($e->getMessage(), 401);
        }
    }

    public function get(int $id)
    {
        try {
            $product = $this->productRepository->find($id);

            return (array) $product;
        } catch (RepositoryException $e) {
            throw new ControllerException($e->getMessage(), 404);
        }
    }

    public function getByCode(string $code)
    {
        try {
            $product = $this->productRepository->findByCode($code);

            return (array) $product;
        } catch (RepositoryException $e) {
            throw new ControllerException($e->getMessage(), 404);
        }
    }

    public function delete(int $id)
    {
        try {
            $this->productRepository->delete($id);
        } catch (RepositoryException $e) {
            throw new ControllerException($e->getMessage(), 404);
        }
    }

    public function edit(int $id, Product $product)
    {
        try {
            $this->productRepository->update($id, (array) $product);
        } catch (RepositoryException $e) {
            throw new ControllerException($e->getMessage(), 404);
        }
    }
}