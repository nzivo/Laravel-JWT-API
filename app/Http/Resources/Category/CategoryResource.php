<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'=> $this->category_name,
            'category_description'=> $this->category_description,
            'category_status'=> $this->category_status,
            'href' => [
                'link'=> route('bookTypes.index',$this->id)
            ]
        ];
    }
}
