<?php
namespace Sales\Transaction\Services;

use App\Models\Transaction;
use Sales\Transaction\Repositories\TransactionRepository;
use Sales\Transaction\Strategies\IncomeStrategy;
use Sales\Transaction\Strategies\OutcomeStrategy;
use Sales\Core\Abstracts\AbstractService;

class TransactionService  extends AbstractService {

    public function __construct(TransactionRepository $repo) {
        $this->repo = $repo;
    }

    public function store(array $params):array
    {
        switch ($params['type']) {
            case 'income':
                return (new IncomeStrategy($this->repo))->run($params);
            case 'outcome':
                return (new OutcomeStrategy($this->repo))->run($params);
            default:
                return [
                    'error' => 'type is not defined'
                ];
        }
    }
    public function getAll($filter_params = []): array
    {
        if($filter_params != []){
            return $this->repo->getAllWithFilter($filter_params);
        }else{
            return $this->repo->getAll();
        }
    }
}