<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category_name'=> $this->category_name,
            'category_description'=> $this->category_description,
            'category_status'=> $this->category_status,
            'href' => [
                'link'=> route('category.show', $this->id)
            ]
        ];
    }
}
