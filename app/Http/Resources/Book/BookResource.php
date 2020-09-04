<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'book_photo' => $this->book_photo,
            'book_name' => $this->book_name,
            'book_description' => $this->book_description,
            'book_author' => $this->book_author,
            'book_publisher' => $this->book_publisher,
            'book_pages' => $this->book_pages,
            'book_year' => $this->book_year,
            'catalogue_no' => $this->catalogue_no,
            'accession_no' => $this->accession_no,
            'book_status' => $this->book_status,
            'category_id' => $this->category_id,
            'book_type_id' => $this->book_type_id,
            'category' => $this->category->category_name,
            'type_name' => $this->book_type->type_name
        ];
    }
}
