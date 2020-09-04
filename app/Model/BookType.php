<?php

namespace App\Model;

use App\Model\Book;
use App\Model\Category;
use Illuminate\Database\Eloquent\Model;

class BookType extends Model
{
    protected $fillable = [
        'type_name', 'type_description', 'category_id'
    ];

    public function category()
    {
        # code...
        return $this->belongsTo(Category::class);
    }

    public function books()
    {
        # code...
        return $this->hasMany(Book::class);
    }

}
