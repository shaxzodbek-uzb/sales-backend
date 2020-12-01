<?php
namespace Sales\Product\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Sales\Batch\Resources\BatchResource;

class ProductResource extends JsonResource
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
            'sku' => $this->sku,
            'name' => $this->name,
        ];
    }
}