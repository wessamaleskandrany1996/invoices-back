<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class ProductResourse extends JsonResource
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
            'id' => $this->id,
            'name'=> $this->name,
            'sell_price'=> $this->sell_price,
            'amount'=> $this->amount,
            'category'=> new CategoryResource($this->Category),
            // 'category'=> $this->category->name,
            'created_at'=>$this ->created_at,
            'updated_at'=>$this->updated_at

        ];
    }
}
