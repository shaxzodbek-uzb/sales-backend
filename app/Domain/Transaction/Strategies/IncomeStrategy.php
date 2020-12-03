<?php
namespace Sales\Transaction\Strategies;

use App\Models\Transaction;
use DB;
use Sales\Batch\Services\BatchService;
use Sales\Transaction\Repositories\TransactionRepository;
use Sales\Transaction\Resources\TransactionResource;
use  Carbon\Carbon;

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
            $params['performed_at'] = new Carbon($params['products'][0]['date']);
            $transaction = $this->createTransaction($params);
            foreach ($params['products'] as $product){
                $batch = $this->batchService->createBatch([
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'performed_at' => new Carbon($product['date'])??now(),
                    'code' => $product['code']??null
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
            dd($e);
            return [
                'error' => $e->getMessage
            ];
        }
    }
    
    public function createTransaction($params): Transaction
    {
        return $this->repo->create([
            'type' => $params['type'],
            'performed_at' => $params['performed_at'],
        ]);
    }
}