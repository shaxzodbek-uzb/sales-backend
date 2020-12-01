<?php
namespace Sales\Transaction\Repositories;

use App\Models\Transaction;
use Sales\Core\Abstracts\AbstractRepository;
use Sales\Core\Interfaces\RepositoryInterface;

class TransactionRepository extends AbstractRepository implements RepositoryInterface {

    public function __construct(Transaction $entity) {
        $this->entity = $entity;
    }

}