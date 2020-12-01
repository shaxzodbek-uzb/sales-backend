<?php
namespace Sales\Transaction\Strategies;

use App\Models\Transaction;
use DB;
use Sales\Batch\Services\BatchService;
use Sales\Transaction\Repositories\TransactionRepository;
use Sales\Transaction\Resources\TransactionResource;

class IncomeStrategy {
    private $repo;
    private $batchService;

    public function __construct(TransactionRepository $repo) {
        $this->repo = $repo;
        $this->batchService = app()->make(BatchService::class);
    }

    public function run(array $params): array
    {
        
        try{
            DB::beginTransaction();
            $transaction = $this->createTransaction($params);
            foreach ($params['products'] as $product){
                $batch = $this->batchService->createBatch([
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ]);
                $transaction->batches()->attach($batch, [
                    'price' => $product['price'], 
                    'quantity' => $product['quantity']
                ]);
            }
            DB::commit();
            $transaction->load('batches');
            
            return ['transaction' => new TransactionResource($transaction)];
        }
        catch(\Exception $e){
            DB::rollBack();
            return [
                'error' => $e->getMessage
            ];
        }
    }
    
    public function createTransaction($params): Transaction
    {
        return $this->repo->create([
            'type' => $params['type']
        ]);
    }
}