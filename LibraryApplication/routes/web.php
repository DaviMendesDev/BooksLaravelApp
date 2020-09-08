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

Route::get('/', function () {
    return view('welcome');
});

// Routes with the '/books' prefix
Route::prefix('/books')->group(function () {
    Route::post('/new', 'BooksController@saveNewBook')->middleware(['auth']);
    Route::get('/new', 'BooksController@showSaveNewBookForm')->middleware(['auth']);

    Route::get('/{id}', 'BooksController@showBook');
});

Route::get('/home', 'HomeController@index')->name('home');
