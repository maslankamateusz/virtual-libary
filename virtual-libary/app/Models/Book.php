<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'author', 'publication_year', 'description'];
    public function reviews()
    {
        return $this->hasMany(Review::class, 'book_id');
    }

}
