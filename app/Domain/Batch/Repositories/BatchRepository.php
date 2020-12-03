<?php
namespace Sales\Batch\Repositories;

use App\Models\Batch;
use Sales\Core\Abstracts\AbstractRepository;
use Sales\Core\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

class BatchRepository extends AbstractRepository implements RepositoryInterface {
    
    public function __construct(Batch $entity) {
        $this->entity = $entity;
    }
    public function getNotEmptyBatches($code, $product_id): Collection
    {
        $batches = clone $this->entity;
        $batches = $batches->where('quantity', '>', 0);
        if($code)
            $batches = $batches->where('code', $code);
        if($product_id)
            $batches = $batches->where('product_id', $product_id);
        return $batches->orderBy('performed_at')->get();
    } 
}