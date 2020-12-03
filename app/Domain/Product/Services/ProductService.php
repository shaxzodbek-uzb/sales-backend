<?php
namespace Sales\Product\Services;

use App\Models\Product;
use Sales\Product\Repositories\ProductRepository;
use illuminate\Support\Collection;
use Sales\Core\Abstracts\AbstractService;

class ProductService extends AbstractService {
    
    public function __construct(ProductRepository $repo) {
        $this->repo = $repo;
    }
}