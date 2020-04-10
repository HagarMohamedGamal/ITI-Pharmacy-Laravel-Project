<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'area'=>new AreaResource($this->area),
            'street_name'=> $this->street_name,
            'build_no' => $this->build_no,
            'floor_no' => $this->floor_no,
            'flat_no' => $this->flat_no,
            'is_main' => $this->is_main==1 ? 'YES' :'NO',

        ];
    }
}
