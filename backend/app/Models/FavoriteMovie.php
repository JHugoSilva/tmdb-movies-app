<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends Model
{
    protected $table = "favorite_movies";
    protected $fillable = [
        'id_tmdb',
        'title',
        'tagline',
        'overview',
        'status',
        'release_date',
        'runtime',
        'poster_path',
        'homepage',
        'popularity',
        'vote_count',
        'trailer',
        'genres',
        'production_countries'
    ];

    protected $casts = [
        'release_date' => 'date',
        'trailer' => 'array',
        'genres' => 'array',
        'production_countries' => 'array',
        'popularity' => 'float'
    ];

}
