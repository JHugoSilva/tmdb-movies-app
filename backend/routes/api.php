<?php

use App\Http\Controllers\FavoriteMovieController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;


Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/search', [MovieController::class, 'searchTitle']);

Route::get('/favorites', [FavoriteMovieController::class, 'index']);
Route::get('/favorites/genres', [FavoriteMovieController::class, 'getGenres']);
Route::post('/favorites', [FavoriteMovieController::class, 'store']);
Route::delete('/favorites/{id}', [FavoriteMovieController::class, 'destroy']);

//Rota para testar a API
Route::get('/ping', function(){
    return 'Pingou a API Laravel TMDB';
});

