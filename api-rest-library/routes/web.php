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
Route::post('/api/sing-up','UserController@singup');
Route::post('/api/login','UserController@login');