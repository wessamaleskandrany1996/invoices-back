<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResources extends JsonResource
{
  /**
   * Transform the resource class.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'name' => $this->name,
      'inventory_id'=> $this->inventory_id,
      'email' => $this->email,
      'token' => $this->token,
      'created_at' => $this->created_at,
      'updated_at' => $this->updated_at,
    ];
  }
}
