<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::query();
    
        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }
    
        return response()->json($query->get());
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'reviewer_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string',
        ]);

        $review = Review::create($request->all());

        return response()->json($review, 201);
    }

    public function show(Review $review)
    {
        return response()->json($review);
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'reviewer_name' => 'string|max:255',
            'rating' => 'integer|min:1|max:5',
            'content' => 'string',
        ]);

        $review->update($request->all());

        return response()->json($review);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(null, 204);
    }
}
