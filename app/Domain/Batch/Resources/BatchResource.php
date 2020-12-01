<?php
namespace Sales\Batch\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Sales\Transaction\Resources\TransactionResource;
use Sales\Product\Resources\ProductResource;

class BatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'code' => $this->code,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'pivot_price' => $this->whenPivotLoaded('batch_transaction', function () {
                return $this->pivot->price;
            }),
            'pivot_quantity' => $this->whenPivotLoaded('batch_transaction', function () {
                return $this->pivot->quantity;
            }),
            'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
            'performed_at' => $this->performed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}