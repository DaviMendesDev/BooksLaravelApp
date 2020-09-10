<?php

namespace App\Http\Controllers;

use App\Books;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function showSaveNewBookForm () {
        return view('books.new');
    }

    public function saveNewBook () {
        // merge the current user with the new book data
        request()->merge([ 'id_publisher' => auth()->id() ]);

        // get all input data (except the cover)
        $book_data = request()->except(['cover']);

        // makes the validation without the cover
        $validation = Books::creationValidator($book_data);

        // if fails
        if($validation->fails())
            return redirect()->back()->withErrors($validation)->withInput();

        // create the new book model
        $new_book = new Books($book_data);

        try {
            // save the cover on the storage (if it exists)
            if (request()->has('cover')) {
                $cover = request()->file('cover');  // get the cover file

                // store it on Disk
                $path = $cover->store(
                    'public/images'
                );

                // and store path on DB
                $new_book->cover = $path;
            }
            // save the new book on database
            $new_book->save();
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error_message', app('generic_error_message'));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error_message', app('generic_error_message'));
        }

        return redirect(
            route('get-book', ['book' => $new_book])
        )->with('success_message', 'book saved successfuly');
    }

    public function showEditFormBook (Books $book) {
        $current_user = auth()->user();

        // verifies if the current user is the publisher
        if($book->isNotThisUserThePublisher($current_user))
            return redirect()->back();

        return view('books.edit', [ 'book' => $book ]);
    }

    public function editBook (Books $book) {
        // merge the current user with the new book data
        request()->merge([ 'id_publisher' => auth()->id() ]);

        $new_book_data = request()->all();
        $current_user = auth()->user();

        // verifies if the current user is the publisher
        if($book->isNotThisUserThePublisher($current_user))
            return redirect()->back();

        // makes the validation
        $validation = Books::creationValidator($new_book_data);

        // if fails
        if($validation->fails())
            return redirect()->back()->withErrors($validation)->withInput();

        $book->title = $new_book_data['title'];
        $book->synopsis = $new_book_data['synopsis'];
        $book->category = $new_book_data['category'];
        $book->publishing_company = $new_book_data['publishing_company'];
        $book->author = $new_book_data['author'];
        $book->edition = $new_book_data['edition'];
        $book->year = $new_book_data['year'];
        $book->page_numbers = $new_book_data['page_numbers'];

        try {
            // save the cover on the storage (if it exists)
            if (request()->has('cover')) {
                $cover = request()->file('cover');  // get the cover file

                // store it on Disk
                $path = $cover->store(
                    'public/images'
                );

                // and store path on DB
                $book->cover = $path;
            }
            $book->save();
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error_message', app('generic_error_message'));
        }

        return redirect()->back()->with('success_message', 'book updated successfuly');
    }

    public function deleteBook (Books $book) {
        $current_user = auth()->user();

        // verifies if the current user is the publisher
        if($book->isNotThisUserThePublisher($current_user))
            return redirect()->back();

        try {
            $book->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('error_message', app('generic_error_message'));
        }

        return redirect()->home()->with('success_message', 'book deleted successfuly');
    }

    public function getMostTrendedBooks () {
        $books = Books::getMostTrendedBooks()->paginate(15);

        return view('books.list-books', [ 'books' => $books]);
    }

    public function getBook (Books $book) {
        return view('books.show-book', [ 'book' => $book]);
    }

    public function getMyBooks() {
        $my_books = auth()->user()->getMyBooks()->paginate(15);
        return view('books.list-books', [ 'books' => $my_books]);
    }

    public function searchBook() {
        $title = request()->input('title');
        $books = Books::where('title', 'LIKE', '%' . $title . '%')->paginate(15);

        return view('books.list-books', [ 'books' => $books ]);
    }
}
