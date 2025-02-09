<?php

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['book_id', 'reviewer_name', 'rating', 'content'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
