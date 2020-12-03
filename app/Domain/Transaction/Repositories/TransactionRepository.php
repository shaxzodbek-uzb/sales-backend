<?php
namespace Sales\Transaction\Repositories;

use App\Models\Transaction;
use Sales\Core\Abstracts\AbstractRepository;
use Sales\Core\Interfaces\RepositoryInterface;
use Sales\Transaction\Resources\TransactionResource;

class TransactionRepository extends AbstractRepository implements RepositoryInterface {

    public function __construct(Transaction $entity) {
        $this->entity = $entity;
        $this->listName = 'transactions';
        $this->resourceClass = TransactionResource::class;
        $this->orderBy = 'performed_at';
        $this->orderType = 'desc';
        $this->withRelation = 'batches.product';
    }
    public function getAllWithFilter($filter_params): array
    {
        
        if($this->withRelation)
            $this->entity = $this->entity->with($this->withRelation);
        if(isset($filter_params['only']))
            $this->entity = $this->entity->where('type', $filter_params['only']);
        if(isset($filter_params['date_from']))
            $this->entity = $this->entity->where('performed_at', '>=', $filter_params['date_from']);
        if(isset($filter_params['date_to']))
            $this->entity = $this->entity->where('performed_at', '<', $filter_params['date_to']);
        return [$this->listName => $this->resourceClass::collection($this->entity->orderBy($this->orderBy, $this->orderType)->get())];
    }
}   