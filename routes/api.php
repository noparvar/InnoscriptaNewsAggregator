<?php

use App\Http\Controllers\Api\V1\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
    // Endpoint to retrieve a list of articles
    Route::get('/articles', [ArticleController::class, 'index']);

    // Endpoint for searching articles
    Route::get('/articles/search', [ArticleController::class, 'search']);
});
