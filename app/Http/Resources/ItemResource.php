<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TownshipResource;
use App\Township;
class ItemResource extends JsonResource
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
            'id'=>$this->id,
            'item_code' => $this->codeno,
            'item_amount'=>$this->amount,
            'township'=>new TownshipResource(Township::find($this->township_id)),
        ];
    }
}