<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'ordered_at' => $this->created_at,
            'status' => $this->status,
            'is_insured' => $this->is_insured,
            'useraddress_id' => $this->useraddress_id,
            'status' => $this->status,
            'priscriptions' => $this->images
        ];

    }
}
