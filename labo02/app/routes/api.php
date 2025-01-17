<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogpostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::get('blogposts', [ApiController::class, 'blogposts']);
//Route::get('blogposts/{id}', [ApiController::class, 'singleBlogpost'])->where(['id' => '[0-9]+']);
Route::resource('blogposts', BlogpostController::class);
Route::resource('tags', TagController::class);
