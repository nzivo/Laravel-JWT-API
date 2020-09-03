<?php

namespace App\Http\Resources\BookType;

use Illuminate\Http\Resources\Json\JsonResource;

class BookTypeResource extends JsonResource
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
            'id' => $this->id,
            'type_name' => $this->type_name,
            'type_description' => $this->type_description,
            'category_id' => $this->category_id,
            'category' => $this->category->category_name
        ];
    }
}
