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
    return view('welcome');
});

Route::get('/test', function () {
    $text = '<h1>HOLA MUNDO test</h1>';
    return view('test', array(
        'text' => $text
    ));
});

Route::get('test-orm', 'TestController@testOrm');

// API TEST ROUTES
Route::get('/usuario/test','UserController@test');
Route::get('/libro/test','BookController@test');
Route::get('/comentario/test','CommentController@test');

// API UserController Routes
Route::post('/api/sign-up','UserController@signup');
Route::post('/api/login','UserController@login');
Route::put('/api/user/update','UserController@update');
Route::post('/api/user/upload','UserController@upload')->middleware(ApiAuthMiddleware::class);
Route::get('/api/user/avatar/{filename}', 'UserController@getImage');
Route::get('api/user/detail/{id}', 'UserController@detail');

// API BookController Routes
Route::resource('/api/book', 'BookController');

// API CommentController Routes
Route::resource('/api/comment', 'CommentController');

