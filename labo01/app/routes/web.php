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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', function () {
    return redirect('/concerts');
});

Route::get('/concerts', function () {
    return view('index-start');
});

/*Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Post ' . $postId;
});*/

Route::get('concerts?search={term}', function($term) {
    //kutnaam($term);
    return redirect(`search/{$term}`);
});

Route::get('search/{term}' , function ($term){
    view('index-start', ['name' => $term]);
});
