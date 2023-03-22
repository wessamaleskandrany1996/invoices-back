<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesInvoiceResourse extends JsonResource
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
            'code' => $this->code,
            'customer'=> new CustomerResourse($this->customer),
            'total' => $this->total,
            'paid' => $this->paid,
            'status' => $this->status,
            'type' => $this->type,
            'product' => new ProductResourse($this->Product),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
