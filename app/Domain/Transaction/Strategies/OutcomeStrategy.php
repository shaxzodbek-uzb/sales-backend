<?php
namespace Sales\Transaction\Strategies;

use App\Models\Transaction;
use DB;
use Sales\Batch\Services\BatchService;
use Sales\Transaction\Repositories\TransactionRepository;
use Sales\Transaction\Resources\TransactionResource;

class OutcomeStrategy {
    
    private $repo;
    private $batchService;

    public function __construct(TransactionRepository $repo) {
        $this->repo = $repo;
        $this->batchService = app()->make(BatchService::class);
    }
    
    public function run(array $params): array
    {
        if(!$this->isValid($params)){
            return [
                'error' => "erron in validation"
            ];
        }
        try{
            DB::beginTransaction();
            $transaction = $this->createTransaction($params);
            foreach ($params['products'] as $product){
                $batches = $this->batchService->getNotEmptyBatches($product['batch_code']??null, $product['id']);
                $sum = $product['quantity'];
                $i = 0;
                while($sum > 0){
                    $delta = min($sum, $batches[$i]['quantity']);
                    $sum -= $delta;
                    $batches[$i]->quantity = $batches[$i]['quantity'] - $delta;
                    $batches[$i]->save();
                    
                    $transaction->batches()->attach($batches[$i], [
                        'price' => $product['price'], 
                        'quantity' => $delta
                    ]);
                    
                    $i++;
                }
            }
            DB::commit();
            $transaction->load('batches');
            
            return ['transaction' => new TransactionResource($transaction)];
        }
        catch(\Exception $e){
            DB::rollBack();
            dd($e);
            return [
                'error' => 'error'
            ];
        }
    }
    public function isValid(array $params): bool
    {
        foreach ($params['products'] as $product) {
            $sum = $this->batchService->getNotEmptyBatches($product['batch_code']??null, $product['id'])->sum('quantity');
            if($sum < $product['quantity']) {
                return false;
            }
        }
        return true;
    }
    public function createTransaction($params): Transaction
    {
        return $this->repo->create([
            'type' => $params['type']
        ]);
    }
}