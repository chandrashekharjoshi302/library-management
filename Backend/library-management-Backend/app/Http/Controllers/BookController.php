<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Store a new book.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',  // Title must be a string and is required
            'author' => 'required|string',  // Author must be a string and is required
            'publication_year' => 'required|integer|min:1900|max:' . now()->year,  // Publication year must be an integer between 1900 and the current year
            'genre' => 'required|string',  // Genre must be a string and is required
            'image' => 'required|mimes:png,jpg,jpeg,gif|max:2048',  // Image must be one of the specified types and is required; max size of 2MB
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,  // Indicate that the request failed
                'message' => 'Validation Error',  // Custom error message
                'errors' => $validator->errors(),  // Include validation errors
            ], 422);  // 422 Unprocessable Entity status code
        }

        // Generate a unique file name for the image using the current timestamp and the file's extension
        $imageName = time() . '.' . $request->image->extension();

        // Move the uploaded image to the 'uploads' directory within the public folder
        $request->image->move(public_path('uploads'), $imageName);

        // Create a new book record in the database with the validated data
        $book = Book::create([
            'title' => $request->title,  // Set the title field
            'author' => $request->author,  // Set the author field
            'publication_year' => $request->publication_year,  // Set the publication year field
            'genre' => $request->genre,  // Set the genre field
            'image' => $imageName,  // Set the image field with the stored file name
        ]);

        // Return a JSON response with the created book data and a 201 status code
        return response()->json([
            'status' => true,  // Indicate that the request was successful
            'message' => 'Book Added successfully',  // Success message
            'data' => $book  // Include the created book data in the response
        ], 201);  // 201 Created status code for successful creation
    }

    /**
     * Display a listing of books.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Start a new query on the Book model
        $query = Book::query();

        // Check if the request has an 'author' parameter and filter the books by author
        if ($request->has('author')) {
            $query->where('author', $request->author);
        }

        // Check if the request has a 'genre' parameter and filter the books by genre
        if ($request->has('genre')) {
            $query->where('genre', $request->genre);
        }

        // Check if the request has a 'publication_year' parameter and filter the books by publication year
        if ($request->has('publication_year')) {
            $query->where('publication_year', $request->publication_year);
        }

        // Execute the query and get the results
        $books = $query->get();

        // Return a JSON response with the status, message, and data
        return response()->json([
            'status' => true,  // Indicate that the request was successful
            'message' => 'Books retrieved successfully',  // Success message
            'data' => $books  // Include the list of books in the response
        ], 200);  // 200 OK status code for a successful retrieval
    }

    /**
     * Borrow a book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrow($id)
    {
        // Find the book by its ID, or return a 404 error if not found
        $book = Book::findOrFail($id);

        // Check if the book is already borrowed
        if ($book->is_borrowed) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Book already borrowed',  // Error message
            ], 400);  // 400 Bad Request status code
        }

        // Update the book's 'is_borrowed' status to true
        $book->update(['is_borrowed' => true]);

        // Create a new borrow record for the book
        BorrowRecord::create([
            'book_id' => $book->id,  // Set the book ID
            'user_id' => Auth::id(),  // Set the current user's ID
            'borrowed_at' => now(),  // Record the current timestamp
        ]);

        // Return a JSON response with the status, message, and the borrowed book data
        return response()->json([
            'status' => true,  // Indicate that the operation was successful
            'message' => 'Book borrowed successfully',  // Success message
            'data' => $book  // Include the borrowed book data in the response
        ], 200);  // 200 OK status code for a successful operation
    }

    /**
     * Return a borrowed book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function return($id)
    {
        // Find the book by its ID, or return a 404 error if not found
        $book = Book::findOrFail($id);

        // Check if the book is currently borrowed
        if (!$book->is_borrowed) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Book is not borrowed',  // Error message
            ], 400);  // 400 Bad Request status code
        }

        // Update the book's 'is_borrowed' status to false, marking it as returned
        $book->update(['is_borrowed' => false]);

        // Find the borrow record for this book that has not yet been marked as returned
        $record = BorrowRecord::where('book_id', $book->id)
            ->whereNull('returned_at')
            ->firstOrFail();

        // Update the borrow record with the current timestamp to mark it as returned
        $record->update(['returned_at' => now()]);

        // Return a JSON response with the status, message, and the returned book data
        return response()->json([
            'status' => true,  // Indicate that the operation was successful
            'message' => 'Book returned successfully',  // Success message
            'data' => $book  // Include the returned book data in the response
        ], 200);  // 200 OK status code for a successful operation
    }

    /**
     * Display a specific book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Find the book by its ID, or return a 404 error if not found
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Book not found',  // Error message
            ], 404);  // 404 Not Found status code
        }

        // Return a JSON response with the status, message, and the specific book data
        return response()->json([
            'status' => true,  // Indicate that the request was successful
            'message' => 'Book retrieved successfully',  // Success message
            'data' => $book,  // Include the book data in the response
        ], 200);  // 200 OK status code for a successful retrieval
    }

    /**
     * Update a specific book.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {


        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string',  // Validate the title if it's provided
            'author' => 'sometimes|required|string',  // Validate the author if it's provided
            'publication_year' => 'sometimes|required|integer|min:1900|max:' . now()->year,  // Validate the publication year if it's provided
            'genre' => 'sometimes|required|string',  // Validate the genre if it's provided
            'image' => 'nullable|mimes:png,jpg,jpeg,gif|max:2048',  // Validate the image file type if it's provided
        ]);

        // Check if validation failed
        if ($validator->fails()) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Validation Error',  // Error message
                'errors' => $validator->errors(),  // Include validation errors
            ], 422);  // 422 Unprocessable Entity status code
        }

        // Find the book by its ID, return a 404 error if not found
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Book not found',  // Error message
            ], 404);  // 404 Not Found status code
        }

        // Handle image upload if a new image is provided
        $imageName = $book->image;
        if ($request->hasFile('image')) {
            // Delete the old image from the server
            $imagePath = public_path('uploads/' . $imageName);
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Remove the old image
            }

            // Generate a new unique name for the new image and move it to the 'uploads' directory
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
        }

        // Update the book's attributes
        $book->update([
            'title' => $request->title,  // Update the title if provided
            'author' => $request->author,  // Update the author if provided
            'publication_year' => $request->publication_year,  // Update the publication year if provided
            'genre' => $request->genre,  // Update the genre if provided
            'image' => $imageName,  // Update the image
        ]);

        // Return a JSON response with the status, message, and updated book data
        return response()->json([
            'status' => true,  // Indicate that the operation was successful
            'message' => 'Book updated successfully',  // Success message
            'data' => $book  // Include the updated book data in the response
        ], 200);  // 200 OK status code for a successful operation
    }

    /**
     * Remove a specific book.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // Find the book by its ID, or return a 404 error if not found
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'status' => false,  // Indicate that the operation failed
                'message' => 'Book not found',  // Error message
            ], 404);  // 404 Not Found status code
        }

        // Handle image deletion if it exists
        $imagePath = public_path('uploads/' . $book->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);  // Delete the image file from the server
        }

        // Delete the book from the database
        $book->delete();

        // Return a JSON response indicating that the book was successfully deleted
        return response()->json([
            'status' => true,  // Indicate that the operation was successful
            'message' => 'Book deleted successfully',  // Success message
        ], 200);  // 200 OK status code for a successful operation
    }
}
