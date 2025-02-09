<?php

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'publication_year', 'description'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
