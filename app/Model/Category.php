<?php

namespace App\Model;

use App\Model\Book;
use App\Model\BookType;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name', 'category_description', 'category_status'
    ];

    public function bookTypes()
    {
        # code...
        return $this->hasMany(BookType::class);
    }

    public function books()
    {
        # code...
        return $this->hasMany(Book::class);
    }
}
