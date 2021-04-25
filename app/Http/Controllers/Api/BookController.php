<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
       $books = Book::all();
       if (!$books) {
           return response()->json([
               'success' => false,
               'message' => 'No books founded'
           ], 400);
       }
       return response()->json([
           'success' => true,
           'data' => $books->toArray()
       ], 200);
    }

    public function store(Request $request)
    {
        $book = new Book;
        $book->ISBN = $request->ISBN;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->editorial = $request->editorial;
        $book->gender = $request->gender;
        $book->user_id = auth()->user()->id;
        $book->save();

        return response()->json([
            'success' => true,
            'message' => 'Book created'
        ], 200);
    }

    public function show($id)
    {
        $books = Book::find($id);
        if (!$books) {
            return response()->json([
                'success' => false,
                'message' => 'Not found book whit id= ' .$id
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $books->toArray()
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Not found book whit id= ' .$id
            ], 400);
        }

        if (auth()->user()->id != $book->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission'
            ], 400);
        }

        $book->update([
            'ISBN' => $request->ISBN,
            'title' => $request->title,
            'author' => $request->author,
            'editorial' => $request->editorial,
            'gender' => $request->gender
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Updated book ' .$id
        ], 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);

        if (auth()->user()->id != $book->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission'
            ], 400);
        }
        Book::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Deleted book ' .$id
        ], 200);
    }
}
