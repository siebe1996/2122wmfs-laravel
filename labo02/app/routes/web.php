<?php

use App\Http\Controllers\FiddleController;
use App\Http\Controllers\BlogController;
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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('fiddleone', [FiddleController::class, 'one']);
Route::get('fiddletwo', [FiddleController::class, 'two']);
Route::get('fiddlethree', [FiddleController::class, 'three']);
Route::get('fiddlefour', [FiddleController::class, 'four']);
Route::get('fiddlefive', [FiddleController::class, 'five']);
Route::get('fiddlesix', [FiddleController::class, 'six']);
Route::get('fiddleseven', [FiddleController::class, 'seven']);
Route::get('fiddleeight', [FiddleController::class, 'eight']);
Route::get('fiddlenine', [FiddleController::class, 'nine']);
Route::get('fiddleten', [FiddleController::class, 'ten']);
Route::get('fiddleeleven', [FiddleController::class, 'eleven']);
Route::get('test/{id}', [FiddleController::class, 'test']);

Route::get('/', [BlogController::class,'home']);
Route::get('blogposts/{id}', [BlogController::class, 'blogpost'])->where(['id' => '[0-9]+']);
Route::get('blogposts/add', [BlogController::class,'add']);
Route::get('blogposts/search', [BlogController::class, 'search']);
Route::get('categories/{category}', [BlogController::class,'category']);
Route::get('authors/{id}', [BlogController::class, 'author'])->where(['id' => '[0-9]+']);

Route::post('blogposts/add', [BlogController::class,'store']);
Route::post('blogposts/search', [BlogController::class, 'searchThis']);
