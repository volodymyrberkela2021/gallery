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

Route::get('/', function () {
    return redirect('/image-gallery');
});

Route::get('/image-gallery', [\App\Http\Controllers\ImageGalleryController::class, 'index']);
Route::post('/image-gallery', [\App\Http\Controllers\ImageGalleryController::class, 'upload']);
Route::delete('/image-gallery/{id}', [\App\Http\Controllers\ImageGalleryController::class, 'destroy']);
Route::get('/image-gallery/{tag}', [\App\Http\Controllers\ImageGalleryController::class, 'getFiltredImages']);
