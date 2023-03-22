<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'customer'=> CustomerResourse::collection($this->customers),
            'supplier'=> SupplierResource::collection($this->supplier),
            'total' => $this->total,
            'paid' => $this->paid,
            'status' => $this->status,
            'type' => $this->type,
            'sales_products' => ProductResourse::collection($this->salesProducts),
            'purchases_products' => ProductResourse::collection($this->purchasesProducts),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
