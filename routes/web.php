<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TestDbController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice-db', [TestDbController::class, 'practiceDb']);
Route::get('/practice-eloquent', [TestDbController::class, 'practiceEloquent']);

Route::resource('posts', PostController::class);