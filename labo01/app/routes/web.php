<?php

use App\Http\Controllers\ConcertController;
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

Route::get('/', [ConcertController::class, 'home']);

Route::get('/concerts', [ConcertController::class, 'overview']);

/*Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return 'Post ' . $postId;
});*/

//Route::get('/concerts?search={term}', [ConcertController::class, 'search']);

Route::get('/search/{term?}', [ConcertController::class, 'search']);

Route::post('/concerts/{id}/toggle', [ConcertController::class, 'changeLike'])->where(['id' => '[0-9]+']);

Route::get('/concerts/{id}', [ConcertController::class, 'concert'])->where(['id' => '[0-9]+']);

Route::get('/concerts/{id}/images/{imgId}', [ConcertController::class, 'images'])->where(['id' => '[0-9]+', 'imgId' => '[0-9]+']);

Route::any('{catchall}', [ConcertController::class, 'notfound'])->where('catchall', '.*');
