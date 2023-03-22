<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryProductResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'product_id' => $this->pivot->product_id,
            'product_name'=>$this->name,
            'amount'=> $this->pivot->amount,
            'sell_price'=>$this->sell_price,
            'category'=>$this->category->name
        ];
    }
}
