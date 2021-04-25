<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(['Books' => Book::orderByDesc('created_at')->get()], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'author' => ['required', 'string', 'min:3', 'max:255'],
            'editorial' => ['required', 'string', 'min:3', 'max:255'],
            'gender' => ['required', 'string', 'min:3', 'max:255'],
            'ISBN' => ['required', 'string', 'min:3', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        Auth::user()->Book()->create($request->all());

        return response()->json([
            'success' => true,
            'data' => "Created"
        ], 200);
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book ' . $id . ' not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $book->toArray()
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book ' . $id . ' not found'
            ], 400);
        }
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'author' => ['required', 'string', 'min:3', 'max:255'],
            'editorial' => ['required', 'string', 'min:3', 'max:255'],
            'gender' => ['required', 'string', 'min:3', 'max:255'],
            'ISBN' => ['required', 'string', 'min:3', 'max:255'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $book->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Updated'
        ], 200);
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'success' => false,
                'message' => 'Book ' . $id . ' not found'
            ], 400);
        }

        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ], 200);
    }
}
