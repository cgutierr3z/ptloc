<?php

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

// Cargar Clases

use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Support\Facades\Route;

// TEST ROUTES
Route::get('/', function () {
    return "";
});

// API UserController Routes
Route::post('/api/sign-up','UserController@signup');
Route::post('/api/login','UserController@login');
Route::put('/api/user/update','UserController@update');
Route::post('/api/user/upload','UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/api/user/avatar/{filename}', 'UserController@getImage');
Route::get('api/user/detail/{id}', 'UserController@detail');

// API BookController Routes
Route::resource('/api/book', 'BookController');
Route::post('/api/book/upload','BookController@upload');
Route::get('/api/book/image/{filename}', 'BookController@getImage');
Route::get('/api/book/user/{id}', 'BookController@getBooksByUser');

// API CommentController Routes
Route::resource('/api/comment', 'CommentController');
Route::get('/api/comment/user/{id}', 'CommentController@getCommentsByUser');
Route::get('/api/comment/book/{id}', 'CommentController@getCommentsByBook');
