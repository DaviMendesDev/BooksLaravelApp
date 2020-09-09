<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Routes with the '/books' prefix
Route::prefix('/books')->group(function () {
    Route::get('/', 'BooksController@getMostTrendedBooks');

    Route::group(['middleware' => ['auth']], function () {
        Route::post('/new', 'BooksController@saveNewBook')->name('new-book');
        Route::get('/new', 'BooksController@showSaveNewBookForm');

        Route::put('/edit/{book}', 'BooksController@editBook');
        Route::get('/edit/{book}', 'BooksController@showEditFormBook')->name('edit-book');

        Route::delete('/delete/{book}', 'BooksController@deleteBook')->name('delete-book');
        Route::get('/my-books', 'BooksController@getMyBooks')->name('my-books');
    });

    Route::get('/{book}', 'BooksController@getBook')->name('get-book');

    Route::post('/search', 'BooksController@searchBook')->name('search-book');
});

Route::get('/home', function() {
    return redirect('/books/');
})->name('home');

Route::get('/', function () {
    return redirect('/books/');
});
