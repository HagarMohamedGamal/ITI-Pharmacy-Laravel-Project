<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveredOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
        [
            'id' => $this->id,
            'mediciens' => $this->medicines,
            'order_total_price' => $this->price,
            'ordered_at' => $this->created_at,
            'status' => $this->status,
            'assigned_pharmacy' => $this->pharmacy,
        ];
    }
}
