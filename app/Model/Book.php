<?php

namespace App\Model;

use App\Model\BookType;
use App\Model\Category;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'book_photo','book_name','book_description','book_author',
        'book_publisher','book_pages','book_year','book_status',
        'category_id','book_type_id',
    ];
    public function category()
    {
        # code...
        return $this->belongsTo(Category::class);
    }

    public function book_type()
    {
        # code...
        return $this->belongsTo(BookType::class);
    }

}
