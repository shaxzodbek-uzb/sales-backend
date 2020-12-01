<?php
namespace Sales\Transaction\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Sales\Batch\Resources\BatchResource;

class TransactionResource extends JsonResource
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
            'type' => $this->type,
            'batches' => BatchResource::collection($this->whenLoaded('batches')),
            'performed_at' => $this->performed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}