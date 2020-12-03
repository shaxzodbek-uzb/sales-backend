<?php
namespace Sales\Product\Repositories;

use App\Models\Product;
use Sales\Core\Abstracts\AbstractRepository;
use Sales\Core\Interfaces\RepositoryInterface;
use Sales\Product\Resources\ProductResource;

class ProductRepository extends AbstractRepository implements RepositoryInterface {
    
    public function __construct(Product $entity)
    {
        $this->entity = $entity;
        $this->listName = 'products';
        $this->resourceClass = ProductResource::class;
    }
}