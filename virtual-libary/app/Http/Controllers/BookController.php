<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();
    
        if ($request->has('sort')) {
            $sortField = $request->sort;
            if (in_array($sortField, ['title', 'author', 'publication_year'])) {
                $query->orderBy($sortField, 'asc');
            }
        }
    
        return response()->json($query->get());
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_year' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function show(Book $book)
    {
        return response()->json($book);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'string|max:255',
            'author' => 'string|max:255',
            'publication_year' => 'integer',
            'description' => 'string',
        ]);

        $book->update($request->all());

        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
    
    public function reviews($id)
    {
        $book = Book::with('reviews')->findOrFail($id);
        return response()->json($book->reviews);
    }
}
