<?php

namespace App\Models; 
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Review extends Model
{
    protected $fillable = ['book_id', 'reviewer_name', 'rating', 'content'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
