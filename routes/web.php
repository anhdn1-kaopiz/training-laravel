<?php

use App\Http\Controllers\TestDbController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/practice-db', [TestDbController::class, 'practiceDb']);
