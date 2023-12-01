<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
        'id' =>$this-> id,
        'name' =>$this-> name,
        'price'=>$this-> price,
        'details' =>$this-> details,
        'photo' =>$this->photo,
        'deleted_at' =>$this-> deleted_at,
        'created_at' =>$this-> created_at,
        'updated_at' =>$this-> updated_at,
        ]; // we use resource in laravael to transform data to json
    }
}
