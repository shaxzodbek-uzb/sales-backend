<?php
namespace Sales\Batch\Services;

use App\Models\Batch;
use Sales\Batch\Repositories\BatchRepository;
use illuminate\Support\Collection;
use Sales\Core\Abstracts\AbstractService;

class BatchService extends AbstractService {
    
    public function __construct(BatchRepository $repo) {
        $this->repo = $repo;
    }

    public function createBatch(array $params): Batch
    {
        return $this->repo->create($params);
    }
    public function getNotEmptyBatches($code = null, $product_id = null): Collection
    {
        return $this->repo->getNotEmptyBatches($code, $product_id);
    }
}